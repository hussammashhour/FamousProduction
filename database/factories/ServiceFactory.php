<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            'Wedding Photography' => ['price' => 1500, 'duration' => 8, 'description' => 'Professional wedding photography capturing your special day with beautiful memories.'],
            'Portrait Session' => ['price' => 200, 'duration' => 2, 'description' => 'Individual and family portrait sessions in studio or outdoor locations.'],
            'Event Photography' => ['price' => 800, 'duration' => 4, 'description' => 'Corporate events, parties, and special occasions photography services.'],
            'Product Photography' => ['price' => 150, 'duration' => 1, 'description' => 'High-quality product photography for e-commerce and marketing needs.'],
            'Family Session' => ['price' => 300, 'duration' => 3, 'description' => 'Family portrait sessions perfect for capturing precious family moments.'],
            'Corporate Event' => ['price' => 1200, 'duration' => 6, 'description' => 'Professional corporate event photography for businesses and organizations.'],
            'Engagement Session' => ['price' => 250, 'duration' => 2, 'description' => 'Romantic engagement photo sessions to celebrate your love story.'],
            'Newborn Photography' => ['price' => 400, 'duration' => 3, 'description' => 'Gentle newborn photography capturing the first precious moments of life.'],
        ];

        $service = $this->faker->randomElement(array_keys($services));
        $details = $services[$service];

        return [
            'name' => $service,
            'description' => $details['description'],
            'price' => $details['price'],
            'duration' => $details['duration'],
            'available' => $this->faker->boolean(80), // 80% chance of being available
        ];
    }
}
