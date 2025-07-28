<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\PostResource;

class GalleryController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $query = Post::with(['user', 'photos', 'comments.user', 'likes.user', 'tags']);

        // Add counts for likes and comments
        $query->withCount(['likes', 'comments']);

        // Get posts ordered by latest with 3 per page
        $posts = $query->latest()->paginate(3);

        // Add is_liked property for authenticated users
        if (Auth::check()) {
            $posts->getCollection()->transform(function ($post) {
                $post->is_liked = $post->likes->contains('user_id', Auth::id());
                return $post;
            });
        }

        return Inertia::render('Gallery', [
            'posts' => $posts,
        ]);
    }

        /**
     * API endpoint for infinite scroll pagination
     */
    public function getPosts(Request $request)
    {
        $query = Post::with(['user', 'photos', 'comments.user', 'likes.user', 'tags']);

        // Add counts for likes and comments
        $query->withCount(['likes', 'comments']);

        // Get page from request, default to 1
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 3);

        // Get posts ordered by latest with pagination
        $posts = $query->latest()->paginate($perPage, ['*'], 'page', $page);

        // Add is_liked property for authenticated users
        if (Auth::check()) {
            $posts->getCollection()->transform(function ($post) {
                $post->is_liked = $post->likes->contains('user_id', Auth::id());
                return $post;
            });
        }

        return $this->successResponse([
            'posts' => PostResource::collection($posts),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'has_more_pages' => $posts->hasMorePages(),
            ]
        ], 'Posts retrieved successfully.');
    }
}
