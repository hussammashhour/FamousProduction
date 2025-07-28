<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Create 15 posts using the factory
        Post::factory()->count(15)->create();

        // Ensure all posts have tags attached
        Post::all()->each(function ($post) {
            if ($post->tags()->count() === 0) {
                // Attach 2-5 random tags to posts that don't have any
                $tags = Tag::inRandomOrder()->limit(rand(2, 5))->get();
                $post->tags()->attach($tags);
            }
        });
    }
}
