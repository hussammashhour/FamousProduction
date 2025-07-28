<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\TestUploadController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\TaggableController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\FaqgableController;
use App\Http\Controllers\Api\SupportTicketController;
use App\Http\Controllers\Api\SupportTicketReplyController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;

//##########  Authentication Endpoints #############
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

//test
Route::get('/test-upload', [TestUploadController::class, 'info']);
Route::post('/test-upload', [TestUploadController::class, 'upload']);

//##########  Public Endpoints #############
Route::post('/users', [UserController::class, 'store']); //Sign Up
Route::get('/posts', [PostController::class, 'index']); // get all posts
Route::get('/gallery/posts', [GalleryController::class, 'getPosts']); // get gallery posts with pagination
Route::get('/home/posts', [HomeController::class, 'getPosts']); // get home page posts with pagination
Route::get('/home/featured-posts', [HomeController::class, 'getFeaturedPosts']); // get featured posts for home
Route::get('/photos', [PhotoController::class, 'index']); // get all photos

// Get current user
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function () {
    return response()->json(\Illuminate\Support\Facades\Auth::user());
    });
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

// User
Route::middleware(['auth:sanctum'])->prefix('users')->group(function () {
    //UserController
    Route::get('/', [UserController::class, 'index']);
    Route::get('{user}', [UserController::class, 'show']);
    Route::put('{user}', [UserController::class, 'update']);
    Route::delete('{user}', [UserController::class, 'destroy']);
    //UserRoleController
    Route::post('{user}/roles/{role}', [UserRoleController::class, 'assign']);
    Route::delete('{user}/roles/{role}', [UserRoleController::class, 'remove']);
    Route::post('{user}/roles/sync', [UserRoleController::class, 'syncRoles']);
});

// Role
Route::middleware(['auth:sanctum'])->prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);       // List all roles
    Route::post('/', [RoleController::class, 'store']);      // Create a new role
    Route::get('{role}', [RoleController::class, 'show']);   // Show a single role
    Route::delete('{role}', [RoleController::class, 'destroy']); // Delete a role
});

// Post
Route::middleware(['auth:sanctum'])->prefix('posts')->group(function () {
    Route::post('/', [PostController::class, 'store']);
    Route::get('{post}', [PostController::class, 'show']);
    Route::put('{post}', [PostController::class, 'update']);
    Route::delete('{post}', [PostController::class, 'destroy']);
    Route::post('{post}/like', [PostController::class, 'like']);
    Route::post('{post}/comments', [PostController::class, 'addComment']);
});

// Photo
Route::middleware(['auth:sanctum'])->prefix('photos')->group(function () {
    Route::post('/', [PhotoController::class, 'store']);
    // Route::get(uri: '{photo}', [PhotoController::class, 'show']);
    Route::put('{photo}', [PhotoController::class, 'update']);
    Route::delete('{photo}', [PhotoController::class, 'destroy']);
});

// Like
Route::middleware(['auth:sanctum'])->prefix('likes')->group(function () {
    Route::get('/', [LikeController::class, 'index']);
    Route::post('/', [LikeController::class, 'store']);
    Route::delete('{like}', [LikeController::class, 'destroy']);
});

// Comment
Route::middleware(['auth:sanctum'])->prefix('comments')->group(function () {
    Route::get('/', [CommentController::class, 'index']);
    Route::post('/', [CommentController::class, 'store']);
    Route::delete('{comment}', [CommentController::class, 'destroy']);
});

// Message
Route::middleware(['auth:sanctum'])->prefix('messages')->group(function () {
    Route::get('/', [MessageController::class, 'index']);
    Route::post('/', [MessageController::class, 'store']);
    Route::put('{message}/read', [MessageController::class, 'markAsRead']);
    Route::delete('{message}', [MessageController::class, 'destroy']);
});

// Service
Route::middleware(['auth:sanctum'])->prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::post('/', [ServiceController::class, 'store']);
    Route::get('{service}', [ServiceController::class, 'show']);
    Route::put('{service}', [ServiceController::class, 'update']);
    Route::delete('{service}', [ServiceController::class, 'destroy']);
});

// Booking
Route::middleware(['auth:sanctum'])->prefix('bookings')->group(function () {
    Route::get('/', [BookingController::class, 'index']);
    Route::post('/', [BookingController::class, 'store']);
    Route::get('{booking}', [BookingController::class, 'show']);
    Route::put('{booking}', [BookingController::class, 'update']);
    Route::delete('{booking}', [BookingController::class, 'destroy']);
});

// Payment
Route::middleware(['auth:sanctum'])->prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('/', [PaymentController::class, 'store']);
    Route::get('{payment}', [PaymentController::class, 'show']);
    Route::put('{payment}', [PaymentController::class, 'update']);
    Route::delete('{payment}', [PaymentController::class, 'destroy']);
});

// Tag
Route::get('/tags', [TagController::class, 'index']); // Public route to get all tags
Route::get('/tags/{tag}/photos', [TagController::class, 'getPhotosByTag']); // Public route to get photos by tag
Route::get('/portfolio/photos', [TagController::class, 'getAllPhotos']); // Public route to get all photos for portfolio

Route::middleware(['auth:sanctum'])->prefix('tags')->group(function () {
    Route::post('/', [TagController::class, 'store']);
    Route::delete('{tag}', [TagController::class, 'destroy']);
});

// TaggableController
Route::middleware('auth:sanctum')->group(function () {
    // POST TAGS
    Route::get('/posts/{post}/tags', [TaggableController::class, 'getPostTags']);
    Route::post('/posts/{post}/tags', [TaggableController::class, 'syncPostTags']);

    // PHOTO TAGS
    Route::get('/photos/{photo}/tags', [TaggableController::class, 'getPhotoTags']);
    Route::post('/photos/{photo}/tags', [TaggableController::class, 'syncPhotoTags']);
});

// Faq
Route::middleware('auth:sanctum')->prefix('faqs')->group(function () {
    Route::get('/', [FaqController::class, 'index']); // ?faqable_type=App\Models\Service&faqable_id=1
    Route::post('/', [FaqController::class, 'store']);
    Route::delete('{faq}', [FaqController::class, 'destroy']);
});

//FaqgableController
Route::middleware(['auth:sanctum'])->group(function () {
    // Services
    Route::get('/services/{service}/faqs', [FaqgableController::class, 'getServiceFaqs']);
    Route::post('/services/{service}/faqs', [FaqgableController::class, 'syncServiceFaqs']);

    // Roles
    Route::get('/roles/{role}/faqs', [FaqgableController::class, 'getRoleFaqs']);
    Route::post('/roles/{role}/faqs', [FaqgableController::class, 'syncRoleFaqs']);
});

// support system
Route::middleware('auth:sanctum')->prefix('tickets')->group(function () {
    Route::get('/', [SupportTicketController::class, 'index']);
    Route::post('/', [SupportTicketController::class, 'store']);
    Route::post('{ticket}/close', [SupportTicketController::class, 'close']);
    Route::post('{ticket}/replies', [SupportTicketReplyController::class, 'store']);
});

// announcements
Route::middleware('auth:sanctum')->prefix('announcements')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index']);
    Route::post('/', [AnnouncementController::class, 'store']);
    Route::get('{announcement}', [AnnouncementController::class, 'show']);
    Route::delete('{announcement}', [AnnouncementController::class, 'destroy']);
});

// Reviews
Route::get('reviews', [ReviewController::class, 'index']);
Route::middleware('auth:sanctum')->prefix('reviews')->group(function () {
    Route::post('/', [ReviewController::class, 'store']);
    Route::delete('{review}', [ReviewController::class, 'destroy']);
});
