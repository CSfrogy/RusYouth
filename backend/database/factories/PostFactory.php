<?php

namespace Database\Factories;

use App\Enums\PostCategory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->admin(),
            'cover_image' => null,
            'title' => fake()->unique()->sentence(),
            'category' => fake()->randomElement(PostCategory::cases())->value,
            'slug' => fn (array $attributes) => Str::slug($attributes['title']),
            'body' => fake()->paragraphs(3, true),
            'published_at' => fake()->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'views' => fn (array $attributes) => $attributes['published_at'] === null
                ? 0
                : fake()->numberBetween(0, 1000),
            'excerpt' => fake()->text(300),
        ];
    }
}
