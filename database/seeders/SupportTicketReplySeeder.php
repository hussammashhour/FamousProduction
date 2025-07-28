<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SupportTicketReply;
use App\Models\SupportTicket;

class SupportTicketReplySeeder extends Seeder
{
    public function run(): void
    {
        // Get existing support tickets and create 1-3 replies for each
        SupportTicket::all()->each(function ($ticket) {
            SupportTicketReply::factory()->count(rand(1, 3))->create([
                'support_ticket_id' => $ticket->id
            ]);
        });
    }
}
