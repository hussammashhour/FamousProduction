<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Resources\LikeResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $likes = Like::with(['user', 'post', 'photo'])->latest()->paginate(10);
        return $this->successResponse(LikeResource::collection($likes), 'Likes retrieved successfully.');
    }

    public function store(StoreLikeRequest $request)
    {
        $like = Like::firstOrCreate([
            'user_id'  => auth()->id(),
            'post_id'  => $request->post_id,
            'photo_id' => $request->photo_id,
        ]);

        return $this->successResponse(new LikeResource($like), 'Like added successfully.', 201);
    }

    public function destroy(Like $like)
    {
        $this->authorize('delete', $like); // Only the user who created the like can delete it
        $like->delete();

        return $this->successResponse([], 'Like removed successfully.');
    }
}
