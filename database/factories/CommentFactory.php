<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'Beautiful work! The lighting is perfect.',
            'I love the composition of this shot.',
            'Amazing photography skills!',
            'This is exactly what I\'m looking for.',
            'The colors are so vibrant and natural.',
            'Great attention to detail.',
            'I can\'t wait to book a session with you!',
            'The editing is flawless.',
            'This photo captures the moment perfectly.',
            'Your style is unique and beautiful.',
        ];

        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'photo_id' => Photo::factory(),
            'comment_text' => $this->faker->randomElement($comments),
        ];
    }
}
