<?php

namespace App\Livewire;

use App\Events\PostCreatedEvent;
use App\Models\Post;
use App\Spiders\Client;
use App\Spiders\GitHubProfileSocialMedia;
use Http;
use Livewire\Component;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class PostForm extends Component
{
    public $forked_url;
    public $original_url;
    public $repo_description;
    public $author_name;
    public $github_user_profile;
    public $linkedin_profile;
    public $facebook_profile;
    public $twitter_profile;
    public $author_website;
    public $additional_links = [];


    public function render()
    {
        return view('livewire.post-form');
    }

    public function fetchData()
    {
        $this->validate([
            'forked_url' => ['required', 'url' , function($attribute, $value, $fail) {
                if (!\Str::startsWith(strtolower(trim($value)), 'https://github.com/yemenopensource/')) {
                    $fail('The forked url must be a valid Yemen Open Source forked url.');
                }
            }],
        ], [
            'forked_url.required' => 'The forked url is required to fetch data.',
        ]);

        $repoPath = \Str::of($this->forked_url)
            ->replace('https://github.com/', 'https://api.github.com/repos/', $this->forked_url)
            ->value();


        $results = Http::get($repoPath)->fluent();

        if (data_get($results, 'parent.owner.type') === 'Organization') {

            $this->original_url = data_get($results, 'parent.html_url');

            $repoUrl = 'https://api.github.com/repos/' . data_get($results, 'parent.full_name');

            $orgRepoResults = Http::get($repoUrl)->fluent();

            $this->repo_description = data_get($orgRepoResults, 'description');

            //dd(
            //    'https://api.github.com/orgs/'.  data_get($orgRepoResults, 'owner.login')
            //);
            $orgResults = Http::get('https://api.github.com/orgs/' . data_get($orgRepoResults, 'owner.login'))->fluent();

            $authorResult = Http::get(data_get($orgResults, 'members_url'))->fluent();

            $authorUrl = data_get($authorResult , '0.url');

            $this->github_user_profile = data_get($authorResult , '0.html_url');


        } else {
             $this->original_url = data_get($results, 'parent.html_url');

             $authorUrl = data_get($results, 'parent.owner.url');

             $this->repo_description = data_get($results, 'parent.description');

            $this->github_user_profile = data_get($results, 'parent.owner.html_url');
        }

        $authorUrlResult = Http::get($authorUrl)->fluent();

        $Arabic = new \ArPHP\I18N\Arabic();

        $englishAuthorName = $authorUrlResult->name;

        // todo use yamli to generate the arabic name
        $this->author_name = $Arabic->en2ar($englishAuthorName);


        $client = new HttpBrowser();

        $crawler = $client->request('GET', $this->github_user_profile);

        $elements = $crawler->filter('.Link--primary[style*="overflow-wrap: anywhere"]');

        $scrapedLinks = $elements->filter('a')->each(function ($link) {
            return $link->attr('href');
        });

        $unmergedLinks = collect($scrapedLinks)
            ->map(function ($link) {
                if (\Str::startsWith($link, ['https://www.linkedin.com/', 'https://linkedin.com/in/'])) {
                    return [
                        'linkedin' => $link,
                    ];
                }

                if (\Str::startsWith($link, ['https://www.facebook.com/', 'https://facebook.com/'])) {
                    return [
                        'facebook' => $link,
                    ];
                }

                return [];
            })
            ->filter()
            ->all();

        $this->author_website = \Str::start($authorUrlResult->blog , 'https://' ) ;

        $links = [];
        foreach ($unmergedLinks as $item) {
            $links = array_merge($links, $item);
        }


        if (data_get($links, 'linkedin')) {
            $this->linkedin_profile = $links['linkedin'];
        }

        if ($authorUrlResult->twitter_username) {
            $this->twitter_profile = 'https://x.com/'.$authorUrlResult->twitter_username;
        }

        if (data_get($links, 'facebook')) {
            $this->facebook_profile = $links['facebook'];
        }
    }

    public function updatedAdditionalLinks($links)
    {
        $linksArr = explode("\n", $links);

        $links = collect($linksArr)
            ->map(function ($link) {
                return \Str::squish($link);
            })
            ->filter(fn($link) => \Str::isUrl($link))
            ->unique()
            ->all();

        $this->additional_links = $links;
    }


    // public function updatedAuthorName($name)
    // {
    //     $linksArr = explode("\n", $links);

    //     $links = collect($linksArr)
    //         ->map(function ($link) {
    //             return \Str::squish($link);
    //         })
    //         ->filter(fn($link) => \Str::isUrl($link))
    //         ->unique()
    //         ->all();

    //     $this->additionalLinks = $links;
    // }


    // trigger when the additionalLinks is updated

    public function submit(): void
    {
        $validated = $this->validate([
            'forked_url' => ['nullable', 'url'],
            'original_url' => ['required', 'url'],
            'repo_description' => ['required', 'string'],
            'author_name' => ['required', 'string'],
            'github_user_profile' => ['nullable', 'string', 'url'],
            'linkedin_profile' => ['nullable', 'string', 'url'],
            'facebook_profile' => ['nullable', 'string', 'url'],
            'twitter_profile' => ['nullable', 'string', 'url'],
            'author_website' => ['nullable', 'string', 'url'],
            'additional_links' => ['nullable', 'array'],
            'additional_links.*' => ['nullable', 'string', 'url'],
        ]);

        //dd($validated);

       $post = Post::updateOrCreate([
            'original_url'=> $validated['original_url'],
        ], $validated);


        $this->dispatch('post-created', $post->id);
    }
}
