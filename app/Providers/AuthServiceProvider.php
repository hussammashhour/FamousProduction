<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Photo;
use App\Models\Review;
use App\Models\Announcement;
use App\Models\SupportTicket;
use App\Models\Faq;
use App\Models\Tag;
use App\Models\Message;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Role;
use App\Models\Attachment;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\ServicePolicy;
use App\Policies\BookingPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\PhotoPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\AnnouncementPolicy;
use App\Policies\SupportTicketPolicy;
use App\Policies\FaqPolicy;
use App\Policies\TagPolicy;
use App\Policies\MessagePolicy;
use App\Policies\CommentPolicy;
use App\Policies\LikePolicy;
use App\Policies\RolePolicy;
use App\Policies\AttachmentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class,
        User::class => UserPolicy::class,
        Service::class => ServicePolicy::class,
        Booking::class => BookingPolicy::class,
        Payment::class => PaymentPolicy::class,
        Photo::class => PhotoPolicy::class,
        Review::class => ReviewPolicy::class,
        Announcement::class => AnnouncementPolicy::class,
        SupportTicket::class => SupportTicketPolicy::class,
        Faq::class => FaqPolicy::class,
        Tag::class => TagPolicy::class,
        Message::class => MessagePolicy::class,
        Comment::class => CommentPolicy::class,
        Like::class => LikePolicy::class,
        Role::class => RolePolicy::class,
        Attachment::class => AttachmentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
