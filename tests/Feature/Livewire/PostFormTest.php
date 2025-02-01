<?php

use App\Livewire\PostForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(PostForm::class)
        ->assertStatus(200);
});
