<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Resources\TagResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return $this->successResponse(TagResource::collection(Tag::all()), 'Tags retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:tags,name']);
        $tag = Tag::create($request->only('name'));

        return $this->successResponse(new TagResource($tag), 'Tag created successfully.', 201);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return $this->successResponse([], 'Tag deleted successfully.');
    }
}
