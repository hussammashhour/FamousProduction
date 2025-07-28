<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = [
            'wedding', 'portrait', 'family', 'engagement', 'newborn', 'corporate', 'event',
            'outdoor', 'studio', 'natural-light', 'black-and-white', 'color', 'vintage',
            'modern', 'classic', 'artistic', 'documentary', 'fine-art', 'commercial',
            'boudoir', 'maternity', 'senior-portraits', 'graduation', 'birthday',
            'anniversary', 'christmas', 'halloween', 'summer', 'winter', 'spring', 'fall',
            'beach', 'mountain', 'urban', 'rural', 'indoor', 'sunset', 'sunrise',
            'night', 'day', 'candid', 'posed', 'group', 'individual', 'couple',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($tags),
        ];
    }
}
