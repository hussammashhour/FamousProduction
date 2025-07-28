<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
        $titles = [
            'Beautiful Wedding at Sunset Beach',
            'Portrait Session in Downtown',
            'Corporate Event Photography',
            'Family Session in the Park',
            'Product Photography Tips',
            'Behind the Scenes: Wedding Prep',
            'Newborn Photography Session',
            'Engagement Photos in the Mountains',
            'Event Photography Highlights',
            'Photography Equipment Review',
        ];

        $descriptions = [
            'Capturing beautiful moments at the beach with perfect lighting and natural poses.',
            'Professional portrait session showcasing modern photography techniques.',
            'Corporate event coverage with attention to detail and professional presentation.',
            'Family bonding captured in natural outdoor settings with warm lighting.',
            'Essential tips for product photography that will enhance your business.',
            'Behind-the-scenes look at wedding preparation and photography setup.',
            'Gentle newborn photography session with safety and comfort in mind.',
            'Romantic engagement photoshoot in scenic mountain locations.',
            'Highlights from various events showcasing our photography expertise.',
            'Review of latest photography equipment and its practical applications.',
        ];

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->randomElement($titles),
            'description' => $this->faker->randomElement($descriptions),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            // Attach 2-5 random tags to each post
            $tags = Tag::inRandomOrder()->limit(rand(2, 5))->get();
            $post->tags()->attach($tags);
        });
    }
}
