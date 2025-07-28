<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
//Filament
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar // for filament dev
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'birthdate',
        'phone',
        'address',
        'latitude',
        'longitude',
        'avatar',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthdate'         => 'date',
        'latitude'          => 'decimal:7',
        'longitude'         => 'decimal:7',
    ];
//relations

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function bookingsAsClient()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function bookingsAsPhotographer()
    {
        return $this->hasMany(Booking::class, 'photographer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'client_id');
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function ticketReplies()
    {
        return $this->hasMany(SupportTicketReply::class);
    }


    //helper functions
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function hasAnyRole(array $roleNames): bool
    {
        return $this->roles()->whereIn('name', $roleNames)->exists();
    }

    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['admin', 'super_admin', 'technician']);
    }

    // Role-based access control methods
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isTechnician(): bool
    {
        return $this->hasRole('technician');
    }

    public function isPhotographer(): bool
    {
        return $this->hasRole('photographer');
    }

    public function isRegularUser(): bool
    {
        return $this->hasRole('user');
    }

    // Permission methods for different resource access
    public function canManageUsers(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function canManageRoles(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canManageSupportTickets(): bool
    {
        return $this->isSuperAdmin() || $this->isTechnician();
    }

    public function canManageAnnouncements(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function canManageServices(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin() || $this->isPhotographer();
    }

    public function canManageBookings(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin() || $this->isPhotographer();
    }

    public function canManagePayments(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function canManagePosts(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin() || $this->isPhotographer();
    }

    public function canManagePhotos(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin() || $this->isPhotographer();
    }

    public function canManageReviews(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function canManageFaqs(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function canManageTags(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin() || $this->isPhotographer();
    }

    public function canManageMessages(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function canManageComments(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function canManageLikes(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function canManageAttachments(): bool
    {
        return $this->isSuperAdmin() || $this->isAdmin() || $this->isPhotographer();
    }

    //Admin logic
    public function getFilamentName(): string
    {
        return trim($this->first_name . ' ' . ($this->last_name ?? ''));
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->getFilamentName());
    }
}
