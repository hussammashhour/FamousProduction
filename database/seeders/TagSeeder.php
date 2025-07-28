<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        // Create 30 unique tags using the factory
        Tag::factory()->count(30)->create();
    }
}
