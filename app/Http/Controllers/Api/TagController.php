<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all tags with photo counts
     */
    public function index()
    {
        $tags = Tag::where(function($query) {
            $query->whereHas('photos')
                  ->orWhereHas('posts');
        })
        ->orderBy('name')
        ->get();

        // Eager load relationships for all tags at once
        $tags->load(['photos', 'posts.photos']);

        $tags = $tags->map(function($tag) {
            $tag->total_photos_count = count($tag->uniquePhotoIds());
            return $tag;
        });

        return $this->successResponse($tags, 'Tags retrieved successfully.');
    }

    /**
     * Get photos by tag
     */
    public function getPhotosByTag($tagId)
    {
        $tag = Tag::with(['photos', 'posts.photos'])->findOrFail($tagId);
        $photoIds = $tag->uniquePhotoIds();
        $photos = \App\Models\Photo::with(['post.user', 'post.comments', 'post.likes', 'tags', 'post.tags'])
            ->whereIn('id', $photoIds)
            ->get();

        // Add is_liked property for authenticated users
        if (Auth::check()) {
            $photos->each(function ($photo) {
                $photo->post->is_liked = $photo->post->likes->contains('user_id', Auth::id());
            });
        }

        return $this->successResponse([
            'tag' => $tag,
            'photos' => $photos->map(function ($photo) {
                // Get all tags for this photo (direct + from post)
                $photoTags = $photo->tags;
                $postTags = $photo->post->tags;
                $allTags = $photoTags->merge($postTags)->unique('id');

                return [
                    'id' => $photo->id,
                    'url' => $photo->url,
                    'caption' => $photo->caption,
                    'tags' => $allTags->map(function($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->name
                        ];
                    }),
                    'post' => [
                        'id' => $photo->post->id,
                        'title' => $photo->post->title,
                        'description' => $photo->post->description,
                        'user' => $photo->post->user,
                        'likes_count' => $photo->post->likes->count(),
                        'comments_count' => $photo->post->comments->count(),
                        'is_liked' => $photo->post->is_liked ?? false,
                        'created_at' => $photo->post->created_at,
                    ]
                ];
            })
        ], 'Photos by tag retrieved successfully.');
    }

    /**
     * Get all photos for portfolio
     */
    public function getAllPhotos()
    {
        $photos = \App\Models\Photo::with(['post.user', 'post.comments', 'post.likes', 'tags', 'post.tags'])
            ->whereHas('post')
            ->orderBy('created_at', 'desc')
            ->get();

        // Add is_liked property for authenticated users
        if (Auth::check()) {
            $photos->each(function ($photo) {
                $photo->post->is_liked = $photo->post->likes->contains('user_id', Auth::id());
            });
        }

        return $this->successResponse([
            'photos' => $photos->map(function ($photo) {
                // Get all tags for this photo (direct + from post)
                $photoTags = $photo->tags;
                $postTags = $photo->post->tags;
                $allTags = $photoTags->merge($postTags)->unique('id');

                return [
                    'id' => $photo->id,
                    'url' => $photo->url,
                    'caption' => $photo->caption,
                    'tags' => $allTags->map(function($tag) {
                        return [
                            'id' => $tag->id,
                            'name' => $tag->name
                        ];
                    }),
                    'post' => [
                        'id' => $photo->post->id,
                        'title' => $photo->post->title,
                        'description' => $photo->post->description,
                        'user' => $photo->post->user,
                        'likes_count' => $photo->post->likes->count(),
                        'comments_count' => $photo->post->comments->count(),
                        'is_liked' => $photo->post->is_liked ?? false,
                        'created_at' => $photo->post->created_at,
                    ]
                ];
            })
        ], 'All photos retrieved successfully.');
    }
}
 