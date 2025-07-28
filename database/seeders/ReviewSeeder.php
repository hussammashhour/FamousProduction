<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Service;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing services and create 2-5 reviews for each
        Service::all()->each(function ($service) {
            Review::factory()->count(rand(2, 5))->create([
                'service_id' => $service->id
            ]);
        });
    }
}
