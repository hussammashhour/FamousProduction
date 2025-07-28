<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // Create 20 bookings using the factory
        Booking::factory()->count(20)->create();
    }
}
