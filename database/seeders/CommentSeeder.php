<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Photo;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        // Create comments for posts (with a random photo)
        Post::all()->each(function ($post) {
            $photos = Photo::all();
            if ($photos->count() > 0) {
                Comment::factory()->count(rand(2, 6))->create([
                    'post_id' => $post->id,
                    'photo_id' => $photos->random()->id
                ]);
            }
        });

        // Create comments for photos (with a random post)
        Photo::all()->each(function ($photo) {
            $posts = Post::all();
            if ($posts->count() > 0) {
                Comment::factory()->count(rand(1, 4))->create([
                    'post_id' => $posts->random()->id,
                    'photo_id' => $photo->id
                ]);
            }
        });
    }
}
