<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;


class GeneratePost extends Component
{
    public $postGenerated = false;
    public $generatedPost;

    public function render()
    {
        // todo fix copy to clipboard
        // todo disable until click on "generate AI post"
        return view('livewire.generate-post');
    }

    #[On('post-created')]
    public function onPostCreated()
    {
        // connect to ollama api

    }
}
