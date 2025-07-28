<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SupportTicket;

class SupportTicketSeeder extends Seeder
{
    public function run(): void
    {
        // Create 25 support tickets using the factory
        SupportTicket::factory()->count(25)->create();
    }
}
