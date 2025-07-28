<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $messages = [
            'Hi! I\'m interested in booking a photography session. Can you tell me more about your packages?',
            'Thank you for the beautiful photos! They turned out exactly as I hoped.',
            'I have a question about the editing process. How long does it typically take?',
            'Can we schedule a consultation to discuss my upcoming wedding photography needs?',
            'I received the photos and they look amazing! Thank you so much.',
            'Do you offer any discounts for booking multiple sessions?',
            'I need to reschedule our session. What dates do you have available?',
            'The photos from our family session are perfect! We\'ll definitely book again.',
            'Can you send me a quote for a corporate event next month?',
            'I love your photography style! When can we book a session?',
        ];

        return [
            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
            'content' => $this->faker->randomElement($messages),
            'is_read' => $this->faker->boolean(70), // 70% chance of being read
            'read_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
