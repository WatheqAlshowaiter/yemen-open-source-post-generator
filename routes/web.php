<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'posts');

Route::resource('posts', App\Http\Controllers\PostController::class)->except('show');
