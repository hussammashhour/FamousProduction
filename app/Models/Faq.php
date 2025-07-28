<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer', 'is_active'];

    // Dynamic relation to any model (e.g., Service, Role, etc.)
    public function faqables()
    {
        return $this->morphToMany(Model::class, 'faqable');
    }

    public function services()
    {
        return $this->morphedByMany(Service::class, 'faqable');
    }

    public function roles()
    {
        return $this->morphedByMany(Role::class, 'faqable');
    }

    

    public function payments()
    {
        return $this->morphedByMany(Payment::class, 'faqable');
    }
}
