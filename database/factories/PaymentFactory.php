<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethods = ['credit_card', 'debit_card', 'bank_transfer', 'paypal', 'cash'];
        $statuses = ['pending', 'completed', 'failed', 'refunded'];

        return [
            'booking_id' => Booking::factory(),
            'client_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 2000),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'status' => $this->faker->randomElement($statuses),
            'transaction_reference' => 'TXN' . $this->faker->unique()->numberBetween(100000, 999999),
        ];
    }
}
