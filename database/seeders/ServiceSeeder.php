<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Create 8 services using the factory
        Service::factory()->count(8)->create();
    }
}
