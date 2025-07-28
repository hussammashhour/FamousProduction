<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageTypes = ['wedding', 'portrait', 'event', 'family', 'product', 'newborn', 'engagement', 'corporate'];
        $imageType = $this->faker->randomElement($imageTypes);

        $captions = [
            'wedding' => ['Beautiful ceremony moment', 'First dance as newlyweds', 'Wedding party celebration'],
            'portrait' => ['Professional headshot', 'Casual outdoor portrait', 'Studio lighting setup'],
            'event' => ['Corporate event coverage', 'Birthday party highlights', 'Conference photography'],
            'family' => ['Family bonding moment', 'Generational portrait', 'Outdoor family session'],
            'product' => ['Product showcase', 'Commercial photography', 'E-commerce ready'],
            'newborn' => ['Sleeping baby portrait', 'Family with newborn', 'Newborn safety setup'],
            'engagement' => ['Proposal moment', 'Engagement ring shot', 'Couple in nature'],
            'corporate' => ['Team building event', 'Executive portrait', 'Office environment'],
        ];

        return [
            'post_id' => Post::factory(),
            'image_url' => "https://picsum.photos/800/600?random=" . $this->faker->numberBetween(1, 1000),
            'caption' => $this->faker->randomElement($captions[$imageType]),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Photo $photo) {
            // Attach 1-3 random tags to each photo
            $tags = Tag::inRandomOrder()->limit(rand(1, 3))->get();
            $photo->tags()->attach($tags);
        });
    }
}
