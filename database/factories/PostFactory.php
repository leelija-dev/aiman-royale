<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Post> */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'excerpt' => substr($this->faker->paragraph(), 0, 250), // Limit to 250 chars to be safe
            'content' => '<p>' . implode('</p><p>', $this->faker->paragraphs(5)) . '</p>',
            'featured_image' => null,
            'status' => $this->faker->randomElement(['draft', 'published']),
            'published_at' => now()->subDays(rand(0, 365)),
            'meta_title' => $title,
            'meta_description' => $this->faker->sentence(12),
            'og_image' => null,
            'author_id' => 1, // adjust as needed
        ];
    }
}
