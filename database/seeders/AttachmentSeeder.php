<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attachment;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create attachments for support tickets
        SupportTicket::all()->each(function ($ticket) {
            // 30% chance of having attachments
            if (rand(1, 100) <= 30) {
                Attachment::factory()->count(rand(1, 3))->create([
                    'attachable_id' => $ticket->id,
                    'attachable_type' => 'App\Models\SupportTicket'
                ]);
            }
        });

        // Create attachments for support ticket replies
        SupportTicketReply::all()->each(function ($reply) {
            // 20% chance of having attachments
            if (rand(1, 100) <= 20) {
                Attachment::factory()->count(rand(1, 2))->create([
                    'attachable_id' => $reply->id,
                    'attachable_type' => 'App\Models\SupportTicketReply'
                ]);
            }
        });
    }
}
