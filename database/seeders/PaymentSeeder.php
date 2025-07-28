<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Booking;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing bookings and create a payment for each
        Booking::all()->each(function ($booking) {
            Payment::factory()->create([
                'booking_id' => $booking->id,
                'client_id' => $booking->client_id,
            ]);
        });
    }
}
