<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Create 8 FAQs using the factory
        Faq::factory()->count(8)->create();
    }
}
