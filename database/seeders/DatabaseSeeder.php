<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
        RoleSeeder::class,
        UserSeeder::class, // Excluded as requested
        ServiceSeeder::class,
        TagSeeder::class,
        PostSeeder::class,
        PhotoSeeder::class,
        BookingSeeder::class,
        PaymentSeeder::class,
        FaqSeeder::class,
        ReviewSeeder::class,
        AnnouncementSeeder::class, // has problems
        SupportTicketSeeder::class,
        SupportTicketReplySeeder::class,
        AttachmentSeeder::class,
        MessageSeeder::class,
        CommentSeeder::class,
        LikeSeeder::class,
    ]);
    }
}
