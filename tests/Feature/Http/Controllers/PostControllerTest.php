<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PostController
 */
final class PostControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $posts = Post::factory()->count(3)->create();

        $response = $this->get(route('posts.index'));

        $response->assertOk();
        $response->assertViewIs('posts.index');
        $response->assertViewHas('posts');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('posts.create'));

        $response->assertOk();
        $response->assertViewIs('posts.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PostController::class,
            'store',
            \App\Http\Requests\PostStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $url = fake()->url();
        $username = fake()->userName();
        $generated_content = fake()->text();
        $generted_title = fake()->word();
        $forked_url = fake()->word();
        $social_links = fake()->;
        $other_links = fake()->;
        $description = fake()->text();

        $response = $this->post(route('posts.store'), [
            'url' => $url,
            'username' => $username,
            'generated_content' => $generated_content,
            'generted_title' => $generted_title,
            'forked_url' => $forked_url,
            'social_links' => $social_links,
            'other_links' => $other_links,
            'description' => $description,
        ]);

        $posts = Post::query()
            ->where('url', $url)
            ->where('username', $username)
            ->where('generated_content', $generated_content)
            ->where('generted_title', $generted_title)
            ->where('forked_url', $forked_url)
            ->where('social_links', $social_links)
            ->where('other_links', $other_links)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $posts);
        $post = $posts->first();

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('post.url', $post->url);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('posts.edit', $post));

        $response->assertOk();
        $response->assertViewIs('posts.edit');
        $response->assertViewHas('post');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PostController::class,
            'update',
            \App\Http\Requests\PostUpdateRequest::class
        );
    }

    #[Test]
    public function update_saves_and_redirects(): void
    {
        $post = Post::factory()->create();
        $url = fake()->url();
        $username = fake()->userName();
        $generated_content = fake()->text();
        $generted_title = fake()->word();
        $forked_url = fake()->word();
        $social_links = fake()->;
        $other_links = fake()->;
        $description = fake()->text();

        $response = $this->put(route('posts.update', $post), [
            'url' => $url,
            'username' => $username,
            'generated_content' => $generated_content,
            'generted_title' => $generted_title,
            'forked_url' => $forked_url,
            'social_links' => $social_links,
            'other_links' => $other_links,
            'description' => $description,
        ]);

        $posts = Post::query()
            ->where('url', $url)
            ->where('username', $username)
            ->where('generated_content', $generated_content)
            ->where('generted_title', $generted_title)
            ->where('forked_url', $forked_url)
            ->where('social_links', $social_links)
            ->where('other_links', $other_links)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $posts);
        $post = $posts->first();

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('post.url', $post->url);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $post = Post::factory()->create();

        $response = $this->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('post.url', $post->url);

        $this->assertModelMissing($post);
    }
}
