<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\Photo;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing photos and create announcements
        $photos = Photo::all();

        // Create 10 announcements
        for ($i = 0; $i < 10; $i++) {
            Announcement::factory()->create([
                'photo_id' => $photos->random()->id
            ]);
        }
    }
}
