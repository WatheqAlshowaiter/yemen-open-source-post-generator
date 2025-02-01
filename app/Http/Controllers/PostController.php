<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController
{
    public function index(Request $request): View
    {
        $posts = Post::all();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create(Request $request): View
    {
        return view('posts.create');
    }

    public function store(PostStoreRequest $request): RedirectResponse
    {
        $post = Post::create($request->validated());

        $request->session()->flash('post.url', $post->url);

        return redirect()->route('posts.index');
    }

    public function edit(Request $request, Post $post): View
    {
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {
        $post->save();

        $request->session()->flash('post.url', $post->url);

        return redirect()->route('posts.index');
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        $post->delete();

        $request->session()->flash('post.url', $post->url);

        return redirect()->route('posts.index');
    }
}
