<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'original_name',
        'mime_type',
        'attachable_id',
        'attachable_type',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }

    // Optional accessor for public URL if using storage link
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
