<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'url' => fake()->url(),
            'username' => fake()->userName(),
            'generated_content' => fake()->text(),
            'generted_title' => fake()->word(),
            'forked_url' => fake()->word(),
            'social_links' => '{}',
            'other_links' => '{}',
            'description' => fake()->text(),
        ];
    }
}
