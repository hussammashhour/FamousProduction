<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reviews = [
            'Absolutely amazing experience! The photographer was professional and captured our special day perfectly.',
            'Great service and beautiful photos. Highly recommend for any photography needs.',
            'Very satisfied with the quality and professionalism. Will definitely book again.',
            'The photographer was patient and made us feel comfortable. Photos turned out stunning.',
            'Excellent communication throughout the process. Photos exceeded our expectations.',
            'Professional, creative, and affordable. Couldn\'t be happier with the results.',
            'The team was friendly and the photos are beautiful. Great value for money.',
            'Outstanding service from start to finish. The photos are absolutely perfect.',
        ];

        return [
            'client_id' => User::factory(),
            'service_id' => Service::factory(),
            'rating' => $this->faker->numberBetween(3, 5), // Mostly positive ratings
            'comment' => $this->faker->randomElement($reviews),
        ];
    }
}
