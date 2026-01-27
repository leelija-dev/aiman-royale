<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure there is at least one admin to own posts
        $admin = Admin::query()->first();
        if (!$admin) {
            $this->command->warn('No admin found. Run SuperAdminSeeder first.');
            return;
        }

        // Create categories and tags
        $categories = Category::factory()->count(5)->create();
        $tags = Tag::factory()->count(8)->create();

        // Create posts
        Post::factory()->count(20)->create([
            'author_id' => $admin->getKey(),
            'status' => 'published',
            'published_at' => now()->subDays(rand(0, 180)),
        ])->each(function (Post $post) use ($categories, $tags) {
            $post->categories()->sync($categories->random(rand(1, 3))->pluck('id')->all());
            $post->tags()->sync($tags->random(rand(1, 4))->pluck('id')->all());
        });
    }
}
