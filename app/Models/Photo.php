<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'image_url',
        'caption',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}

public function tags()
{
    return $this->morphToMany(Tag::class, 'taggable');
}

    /**
     * Get the URL for the photo
     * Handles both local storage paths and external URLs
     */
    public function getUrlAttribute()
    {
        // If it's already a full URL (starts with http), return as is
        if (filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }

        // If it's a local storage path, return the full URL
        if (str_starts_with($this->image_url, 'storage/')) {
            return asset($this->image_url);
        }

        // Default fallback
        return $this->image_url;
    }
}
