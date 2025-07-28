<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class RemovePostsWithoutPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:remove-without-photos {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all posts that do not have any photos associated with them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No posts will be actually deleted');
        }

        // Get posts without photos
        $postsWithoutPhotos = Post::whereDoesntHave('photos')->get();

        $count = $postsWithoutPhotos->count();

        if ($count === 0) {
            $this->info('✅ All posts have photos! No posts to remove.');
            return 0;
        }

        $this->warn("⚠️  Found {$count} posts without photos:");

        // Display the posts that would be deleted
        $this->table(
            ['ID', 'Title', 'User', 'Created At'],
            $postsWithoutPhotos->map(function ($post) {
                return [
                    $post->id,
                    $post->title ?? 'No title',
                    $post->user ? $post->user->first_name . ' ' . $post->user->last_name : 'Unknown',
                    $post->created_at->format('Y-m-d H:i:s')
                ];
            })->toArray()
        );

        if ($isDryRun) {
            $this->info("📋 DRY RUN: {$count} posts would be deleted");
            return 0;
        }

        // Ask for confirmation
        if (!$this->confirm("Are you sure you want to delete {$count} posts without photos?")) {
            $this->info('❌ Operation cancelled.');
            return 0;
        }

        // Delete the posts
        $deletedCount = 0;
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($postsWithoutPhotos as $post) {
            try {
                $post->delete();
                $deletedCount++;
            } catch (\Exception $e) {
                $this->error("Failed to delete post ID {$post->id}: " . $e->getMessage());
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info("✅ Successfully deleted {$deletedCount} posts without photos!");

        // Show remaining posts count
        $remainingPosts = Post::count();
        $this->info("📊 Total posts remaining: {$remainingPosts}");

        return 0;
    }
}
