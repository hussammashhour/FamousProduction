<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function taggables()
    {
        return $this->morphedByMany(Post::class, 'taggable')
            ->union($this->morphedByMany(Photo::class, 'taggable')); // Optional if you want all at once
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function photos()
    {
        return $this->morphedByMany(Photo::class, 'taggable');
    }

    /**
     * Get all unique photo IDs for this tag (directly tagged + from tagged posts)
     */
    public function uniquePhotoIds()
    {
        // Eager load if not loaded
        if (!$this->relationLoaded('photos')) {
            $this->load('photos');
        }
        if (!$this->relationLoaded('posts')) {
            $this->load('posts.photos');
        }

        $directPhotoIds = $this->photos->pluck('id')->toArray();
        $postPhotoIds = $this->posts->flatMap(function($post) {
            return $post->photos->pluck('id')->toArray();
        })->toArray();

        return array_unique(array_merge($directPhotoIds, $postPhotoIds));
    }
}
