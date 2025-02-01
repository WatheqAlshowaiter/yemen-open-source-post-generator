<?php

namespace App\Livewire;

use Http;
use Livewire\Component;

class PostForm extends Component
{
    public $forkedUrl;
    public $originalUrl;
    public $repoDescription;
    public $authorName;
    public $githubUserProfile;
    public $linkedinProfile;
    public $authorWebsite;
    public $additionalLinks = [];
    public $additionalSocialLinks = [];

    public function render()
    {
        // todo loading spinner
        // todo validation
        // todo grid for form and generated post 
        return view('livewire.post-form');
    }

    public function fetchData()
    {   
        if(!$this->forkedUrl)
        {
            // todo valite only the forked url to be required and valid url
        }

        $repoPath = \Str::of($this->forkedUrl)
                        ->replace('https://github.com/','https://api.github.com/repos/', $this->forkedUrl)
                        ->value();

                        

        $results = Http::get($repoPath)->fluent();

        $this->originalUrl = data_get($results, 'parent.html_url');
        $this->repoDescription = data_get($results, 'parent.description');
        
        $authorUrl = data_get($results, 'parent.owner.url');
        $authorUrlResult =  Http::get($authorUrl)->fluent();

        if(data_get($results, 'parent.owner.type') === 'organization')
        {
            // todo get username from the 
        }else { 

            $Arabic = new \ArPHP\I18N\Arabic();

            $englishAuthorName = $authorUrlResult->name;

            $this->authorName = $Arabic->en2ar($englishAuthorName);
        }

        $this->githubUserProfile = data_get($results, 'parent.owner.html_url');


        // todo scrape the linkedin link from the $authorUrl

        $this->authorWebsite = $authorUrlResult->blog;

        if($authorUrlResult->twitter_username){
            $this->additionalSocialLinks[]= 'https://x.com/' . $authorUrlResult->twitter_username;
        }
        
    }

    public function updatedAdditionalLinks($links)
    {
        $linksArr = explode("\n",$links);

        $links = collect($linksArr)
                ->map(function ($link) {
                    return \Str::squish($link);
                })
            ->filter(fn($link) => \Str::isUrl($link))
            ->unique()
            ->all();

        $this->additionalLinks = $links;
    }

    public function updatedAdditionalSocialLinks($links)
    {
        $linksArr = explode("\n",$links);

        $links = collect($linksArr)
                ->map(function ($link) {
                    return \Str::squish($link);
                })
            ->filter(fn($link) => \Str::isUrl($link))
            ->unique()
            ->all();

        $this->additionalSocialLinks = $links;
    }

    // trigger when the additonalLinks is updated

    public function submit()
    {
        dd(
            $this->additionalLinks ,
            $this->additionalSocialLinks
        );
    }
}
