<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class TaggableController extends Controller
{
    use ApiResponseTrait;

    public function syncPostTags(Request $request, Post $post)
    {
        $request->validate([
            'tag_ids' => ['required', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
        ]);

        $post->tags()->sync($request->tag_ids);

        return $this->successResponse([], 'Tags synced for post.');
    }

    public function syncPhotoTags(Request $request, Photo $photo)
    {
        $request->validate([
            'tag_ids' => ['required', 'array'],
            'tag_ids.*' => ['exists:tags,id'],
        ]);

        $photo->tags()->sync($request->tag_ids);

        return $this->successResponse([], 'Tags synced for photo.');
    }

    public function getPostTags(Post $post)
    {
        return $this->successResponse($post->tags, 'Post tags retrieved.');
    }

    public function getPhotoTags(Photo $photo)
    {
        return $this->successResponse($photo->tags, 'Photo tags retrieved.');
    }
}
