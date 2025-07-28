<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        // Create 50 messages using the factory
        Message::factory()->count(50)->create();
    }
}
