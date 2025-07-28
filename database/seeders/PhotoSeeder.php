<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Tag;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing posts and create 2-4 photos for each post
        Post::all()->each(function ($post) {
            Photo::factory()->count(rand(2, 4))->create([
                'post_id' => $post->id
            ]);
        });

        // Ensure all photos have tags attached
        Photo::all()->each(function ($photo) {
            if ($photo->tags()->count() === 0) {
                // Attach 1-3 random tags to photos that don't have any
                $tags = Tag::inRandomOrder()->limit(rand(1, 3))->get();
                $photo->tags()->attach($tags);
            }
        });
    }
}
