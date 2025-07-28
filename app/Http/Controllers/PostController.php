<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $query = Post::with(['user', 'photos', 'comments.user', 'likes.user', 'tags']);

        // Check if user is authenticated to determine if posts are liked
        if (Auth::check()) {
            $query->withCount(['likes', 'comments']);
        }

        $posts = $query->latest()->paginate(10);

        // Add is_liked property for authenticated users
        if (Auth::check()) {
            $posts->getCollection()->transform(function ($post) {
                $post->is_liked = $post->likes->contains('user_id', Auth::id());
                return $post;
            });
        }

        return $this->successResponse(PostResource::collection($posts), 'Posts retrieved successfully.');
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return $this->successResponse(new PostResource($post), 'Post created successfully.', 201);
    }

    public function show($id)
    {
        $post = Post::with(['photos', 'comments.user', 'likes.user', 'tags'])->findOrFail($id);
        return $this->successResponse(new PostResource($post), 'Post retrieved successfully.');
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());
        return $this->successResponse(new PostResource($post), 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();
        return $this->successResponse([], 'Post deleted successfully.');
    }

    public function like(Post $post)
    {
        $user = Auth::user();

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $message = 'Post unliked successfully.';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $message = 'Post liked successfully.';
        }

        return $this->successResponse([], $message);
    }

    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'comment_text' => $request->content
        ]);

        $comment->load('user');

        return $this->successResponse($comment, 'Comment added successfully.');
    }
}
