<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Booking inquiry',
            'Payment issue',
            'Photo delivery question',
            'Service availability',
            'Pricing information',
            'Technical support',
            'Rescheduling request',
            'Quality concern',
        ];

        $statuses = ['open', 'pending', 'resolved', 'closed'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        $descriptions = [
            'I would like to inquire about booking a photography session for my wedding next summer.',
            'I\'m having trouble with the payment process. Can you help me resolve this issue?',
            'When can I expect to receive my photos from the recent session?',
            'I need to know if you\'re available for a corporate event next month.',
            'Could you provide more information about your pricing packages?',
            'I\'m experiencing technical difficulties with the online booking system.',
            'I need to reschedule my upcoming photography session due to a conflict.',
            'I have some concerns about the quality of the photos from my recent session.',
        ];

        return [
            'user_id' => User::factory(),
            'subject' => $this->faker->randomElement($subjects),
            'description' => $this->faker->randomElement($descriptions),
            'status' => $this->faker->randomElement($statuses),
            'priority' => $this->faker->randomElement($priorities),
            'closed_at' => $this->faker->optional(0.3)->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
