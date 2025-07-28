<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ApiResponseTrait;

public function index(Request $request)
{
    $query = Comment::query();

    if ($request->has('post_id')) {
        $query->where('post_id', $request->post_id);
    }

    if ($request->has('photo_id')) {
        $query->where('photo_id', $request->photo_id);
    }

    $comments = $query->with(['user'])->latest()->paginate(10);

    return $this->successResponse(CommentResource::collection($comments), 'Comments retrieved successfully.');
}


public function store(StoreCommentRequest $request)
{
    $comment = Comment::create([
        'user_id'      => auth()->id(),
        'post_id'      => $request->post_id,
        'photo_id'     => $request->photo_id,
        'comment_text' => $request->comment_text,
    ]);

    return $this->successResponse(new CommentResource($comment), 'Comment posted successfully.', 201);
}


    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return $this->successResponse([], 'Comment deleted successfully.');
    }
}
