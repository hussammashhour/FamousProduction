<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileTypes = [
            'image' => ['jpg', 'jpeg', 'png', 'gif'],
            'document' => ['pdf', 'doc', 'docx'],
            'video' => ['mp4', 'avi', 'mov'],
        ];

        $type = $this->faker->randomElement(array_keys($fileTypes));
        $extension = $this->faker->randomElement($fileTypes[$type]);
        $fileName = $this->faker->slug() . '.' . $extension;

        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'mp4' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'mov' => 'video/quicktime',
        ];

        return [
            'file_path' => 'attachments/' . $fileName,
            'original_name' => $fileName,
            'mime_type' => $mimeTypes[$extension],
            'attachable_id' => $this->faker->numberBetween(1, 100),
            'attachable_type' => $this->faker->randomElement(['App\Models\SupportTicket', 'App\Models\SupportTicketReply']),
        ];
    }
}
