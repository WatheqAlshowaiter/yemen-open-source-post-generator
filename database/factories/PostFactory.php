<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'forked_url' => $this->faker->url(),
            'original_url' => $this->faker->url(),
            'repo_description' => $this->faker->text(),
            'author_name' => $this->faker->name(),
            'github_user_profile' => $this->faker->url(),
            'linkedin_profile' => $this->faker->url(),
            'facebook_profile' => $this->faker->url(),
            'twitter_profile' => $this->faker->url(),
            'author_website' => $this->faker->url(),
            'additional_links' => [],
            'generated_title' => $this->faker->word(),
            'generated_content' => $this->faker->realText(),
        ];
    }
}
