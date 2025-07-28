<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        $comments = [
            'Looking forward to our photography session!',
            'Please confirm the location and time.',
            'Special requests for the shoot.',
            'Need to discuss specific requirements.',
            'Excited about the upcoming session.',
            'Please provide details about the venue.',
            'Have some questions about the package.',
            'Ready for our photography appointment.',
            'Looking for a specific style of photography.',
            'Need to coordinate with other vendors.',
        ];

        return [
            'client_id' => User::factory(),
            'photographer_id' => User::factory(),
            'service_id' => Service::factory(),
            'scheduled_date' => $this->faker->dateTimeBetween('now', '+6 months'),
            'status' => $this->faker->randomElement($statuses),
            'comment' => $this->faker->randomElement($comments),
        ];
    }
}
