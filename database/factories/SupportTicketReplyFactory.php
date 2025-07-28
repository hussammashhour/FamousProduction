<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\SupportTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportTicketReply>
 */
class SupportTicketReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messages = [
            'Thank you for contacting us. We\'ll get back to you within 24 hours.',
            'I understand your concern. Let me look into this for you.',
            'We\'re working on resolving this issue. Please bear with us.',
            'Your request has been processed. You should receive an update soon.',
            'I apologize for the inconvenience. Here\'s what we can do to help.',
            'Thank you for bringing this to our attention. We\'re investigating.',
            'We\'ve updated your booking as requested. Please check your email.',
            'Your payment has been processed successfully. Thank you for your patience.',
        ];

        return [
            'support_ticket_id' => SupportTicket::factory(),
            'user_id' => User::factory(),
            'message' => $this->faker->randomElement($messages),
            'is_internal' => $this->faker->boolean(20), // 20% chance of being internal
        ];
    }
}
