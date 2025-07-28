<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_id',
        'created_by',
        'announcement_type',
        'announcement_status',
        'body',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
