<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $announcementTypes = ['news', 'promotion', 'event', 'update'];
        $announcementStatuses = ['draft', 'published', 'archived'];

        $bodies = [
            'news' => [
                'We\'re excited to announce our new studio location opening next month!',
                'Check out our latest photography equipment upgrades for better quality.',
                'New team member joining our photography family.',
            ],
            'promotion' => [
                'Special 20% discount on all wedding packages this month!',
                'Book your family session and get a free engagement shoot.',
                'Limited time offer: 50% off portrait sessions for new clients.',
            ],
            'event' => [
                'Join us for our annual photography workshop this weekend.',
                'Photography exhibition featuring our best work of the year.',
                'Open house event - come see our studio and meet our team.',
            ],
            'update' => [
                'Website maintenance scheduled for this weekend.',
                'New booking system now available for easier scheduling.',
                'Updated pricing for 2024 photography services.',
            ],
        ];

        $type = $this->faker->randomElement($announcementTypes);
        $status = $this->faker->randomElement($announcementStatuses);

        return [
            'photo_id' => Photo::factory(),
            'created_by' => User::factory(),
            'announcement_type' => $type,
            'announcement_status' => $status,
            'body' => $this->faker->randomElement($bodies[$type]),
            'published_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
