<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\PostResource;

class HomeController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get posts for home page with pagination
     */
    public function getPosts(Request $request)
    {
        $query = Post::with(['user', 'photos', 'comments.user', 'likes.user', 'tags']);

        // Add counts for likes and comments
        $query->withCount(['likes', 'comments']);

        // Get page from request, default to 1
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 6); // 6 posts per page for home

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

    /**
     * Get featured posts for home page
     */
    public function getFeaturedPosts(Request $request)
    {
        $query = Post::with(['user', 'photos', 'comments.user', 'likes.user', 'tags']);

        // Add counts for likes and comments
        $query->withCount(['likes', 'comments']);

        // Get featured posts (you can add a featured column to posts table later)
        // For now, we'll get the most liked posts
        $posts = $query->orderBy('likes_count', 'desc')
                      ->limit(3)
                      ->get();

        // Add is_liked property for authenticated users
        if (Auth::check()) {
            $posts->transform(function ($post) {
                $post->is_liked = $post->likes->contains('user_id', Auth::id());
                return $post;
            });
        }

        return $this->successResponse(PostResource::collection($posts), 'Featured posts retrieved successfully.');
    }
}
