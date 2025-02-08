<?php

namespace App\Livewire;

use App\Events\PostCreatedEvent;
use App\Models\Post;
use App\Spiders\Client;
use App\Spiders\GitHubProfileSocialMedia;
use Http;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Stichoza\GoogleTranslate\Exceptions\LargeTextException;
use Stichoza\GoogleTranslate\Exceptions\RateLimitException;
use Stichoza\GoogleTranslate\Exceptions\TranslationRequestException;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PostForm extends Component
{
    public $forked_url;
    public $original_url;
    public $repo_name;
    public $repo_description;
    public $author_name;
    public $github_user_profile;
    public $linkedin_profile;
    public $facebook_profile;
    public $twitter_profile;
    public $author_website;
    public $additional_links = [];
    public $additional_links_string;

    public $repo_tags = ['yemen_open_source', 'yemenopensource'];
    public $repo_tags_string;


    public function mount($postId = null)
    {
        if($postId ){
            $post = Post::findOrFail($postId);
            $this->forked_url = $post->forked_url;
            $this->original_url = $post->original_url;
            $this->repo_name = $post->repo_name;
            $this->repo_description = $post->repo_description;
            $this->author_name = $post->author_name;
            $this->github_user_profile = $post->github_user_profile;
            $this->linkedin_profile = $post->linkedin_profile;
            $this->facebook_profile  = $post->facebook_profile;
            $this->twitter_profile  = $post->twitter_profile;
            $this->author_website = $post->author_website;
            $this->additional_links = $post->additional_links;
            $this->repo_tags = $post->repo_tags;
            $this->repo_tags_string = implode(', ', $post->repo_tags );
            $this->additional_links_string = implode("\n", $post->additional_links);
        }

    }


    public function render()
    {
        return view('livewire.post-form');
    }

    /**
     * @throws LargeTextException
     * @throws RateLimitException
     * @throws TranslationRequestException
     */
    public function fetchData()
    {
        $this->validate([
            'forked_url' => [
                'required', 'url', function ($attribute, $value, $fail) {
                    if (!\Str::startsWith(strtolower(trim($value)), 'https://github.com/yemenopensource/')) {
                        $fail('The forked url must be a valid Yemen Open Source forked url.');
                    }
                }
            ],
        ], [
            'forked_url.required' => 'The forked url is required to fetch data.',
        ]);

        $tr = new GoogleTranslate('ar');

        $this->repo_name = \Str::of(parse_url($this->forked_url, PHP_URL_PATH))
            ->afterLast('/')
            ->headline()
            ->value();

        $repoPath = \Str::of($this->forked_url)
            ->replace('https://github.com/', 'https://api.github.com/repos/', $this->forked_url)
            ->value();

        $results = Http::get($repoPath)->fluent();

        if (data_get($results, 'parent.owner.type') === 'Organization') {

            $this->original_url = data_get($results, 'parent.html_url');

            $repoUrl = 'https://api.github.com/repos/'.data_get($results, 'parent.full_name');

            $orgRepoResults = Http::get($repoUrl)->fluent();

            $this->repo_description = data_get($orgRepoResults, 'description');

            $repoTagsResult = data_get($orgRepoResults, 'topics');

            $this->repo_tags_string = implode(', ', $repoTagsResult);

            //dd(
            //    'https://api.github.com/orgs/'.  data_get($orgRepoResults, 'owner.login')
            //);
            $orgResults = Http::get('https://api.github.com/orgs/'.data_get($orgRepoResults, 'owner.login'))->fluent();

            $authorResult = Http::get(data_get($orgResults, 'members_url'))->fluent();

            $authorUrl = data_get($authorResult, '0.url');

            $this->github_user_profile = data_get($authorResult, '0.html_url');


        } else {
            $repoUrl = 'https://api.github.com/repos/'.data_get($results, 'parent.full_name');
            $repoResults = Http::get($repoUrl)->fluent();

            $repoTagsResult = data_get($repoResults, 'topics');
            $this->repo_tags_string = implode(', ', $repoTagsResult);

            $this->original_url = data_get($results, 'parent.html_url');


            $authorUrl = data_get($results, 'parent.owner.url');

            $this->repo_description = data_get($results, 'parent.description');

            $this->github_user_profile = data_get($results, 'parent.owner.html_url');
        }

        $authorUrlResult = Http::get($authorUrl)->fluent();

        $englishAuthorName = $authorUrlResult->name;

        $this->author_name = match($tr->translate($englishAuthorName)) {
            'عسميل' => 'إسماعيل',
            'موث ألينيودي' => 'معاذ السوادي',
            'عبد الرحمن الوشيبي' => 'عبدالرحمن الصهيبي' ,
            default => $tr->translate($englishAuthorName),
        };

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

        $this->author_website = \Str::start($authorUrlResult->blog, 'https://');

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

    // public function updatedAdditionalLinks($links)
    // {
    //     $linksArr = explode("\n", $links);

    //     $links = collect($linksArr)
    //         ->map(function ($link) {
    //             return \Str::squish($link);
    //         })
    //         ->filter(fn($link) => \Str::isUrl($link))
    //         ->unique()
    //         ->all();

    //     $this->additional_links = $links;
    // }

    public function updatedAdditionalLinksString($links)
    {
        $linksArr = explode("\n", $links);

        $links = collect($linksArr)
            ->map(function ($link) {
                return \Str::squish($link);
            })
            ->filter(fn($link) => \Str::isUrl($link))
            ->unique()
            ->all();

        return $this->additional_links = $links;
    }


    public function updatedRepoTagsString($tags)
    {
        $tagsArr = explode(", ", (string) $tags);

        $tags = collect($tagsArr)
            ->map(function ($tag) {
                return \Str::of($tag)->ltrim('#')->squish()->snake()->value();
            })
            ->filter()
            ->unique()
            ->all();

        return $this->repo_tags = $tags;
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
        $this->repo_tags = $this->updatedRepoTagsString($this->repo_tags_string);
        $this->additional_links = $this->updatedAdditionalLinksString($this->additional_links_string);

        $validated = $this->validate([
            'forked_url' => ['nullable', 'url'],
            'original_url' => ['required', 'url'],
            'repo_name' => ['required', 'string'],
            'repo_description' => ['required', 'string'],
            'repo_tags' => ['nullable', 'array'],
            'repo_tags.*' => ['nullable', 'string'],
            'author_name' => ['required', 'string'],
            'github_user_profile' => ['nullable', 'string', 'url'],
            'linkedin_profile' => ['nullable', 'string', 'url'],
            'facebook_profile' => ['nullable', 'string', 'url'],
            'twitter_profile' => ['nullable', 'string', 'url'],
            'author_website' => ['nullable', 'string', 'url'],
            'additional_links' => ['nullable', 'array'],
            'additional_links.*' => ['nullable', 'string', 'url'],
        ]);

        $post = Post::updateOrCreate([
            'original_url' => $validated['original_url'],
        ], $validated);


        // know if the post is new or not
        if($post->wasRecentlyCreated) {
            // I want to dispatch an event with redirect
            Session::put('redirectedPost',  $post->id);
            redirect()->route('posts.edit', ['post' => $post] );
        }


        // go to the upper in the html page
        $this->dispatch('post-created', $post->id);
    }
}
