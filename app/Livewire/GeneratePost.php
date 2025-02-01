<?php

namespace App\Livewire;

use Livewire\Component;

class GeneratePost extends Component
{
    public $postGenerated = false;

    public function render()
    {
        // todo fix copy to clipboard
        // todo disable until click on "generate AI post"
        return view('livewire.generate-post');
    }
}
