<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faqs = [
            [
                'question' => 'How far in advance should I book a photography session?',
                'answer' => 'We recommend booking at least 2-4 weeks in advance for portrait sessions and 6-12 months for weddings to ensure availability.'
            ],
            [
                'question' => 'What is included in the photography package?',
                'answer' => 'Our packages include professional photography, edited digital images, online gallery access, and print release. Additional services can be added.'
            ],
            [
                'question' => 'Do you travel for photography sessions?',
                'answer' => 'Yes, we offer travel services within a 50-mile radius included in our packages. Additional travel fees may apply for locations beyond this range.'
            ],
            [
                'question' => 'How long does it take to receive my photos?',
                'answer' => 'Portrait sessions typically take 1-2 weeks for delivery, while weddings may take 4-6 weeks depending on the package selected.'
            ],
            [
                'question' => 'Can I request specific editing styles?',
                'answer' => 'Absolutely! We work closely with clients to understand their preferred editing style and can accommodate most requests.'
            ],
            [
                'question' => 'What happens if it rains on my outdoor session?',
                'answer' => 'We offer free rescheduling for weather-related issues. We can also suggest indoor alternatives or covered locations.'
            ],
            [
                'question' => 'Do you provide raw files?',
                'answer' => 'We provide professionally edited high-resolution JPEG files. Raw files are available for an additional fee.'
            ],
            [
                'question' => 'How many photos will I receive?',
                'answer' => 'The number varies by package, but typically 50-100 images for portrait sessions and 300-800 for weddings.'
            ],
        ];

        $faq = $this->faker->randomElement($faqs);

        return [
            'question' => $faq['question'],
            'answer' => $faq['answer'],
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
