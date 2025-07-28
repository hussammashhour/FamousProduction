<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $reviews = Review::with(['client', 'service'])
            ->when($request->service_id, fn($q) => $q->where('service_id', $request->service_id))
            ->latest()
            ->paginate(10);

        return $this->successResponse(ReviewResource::collection($reviews), 'Reviews retrieved.');
    }

    public function store(StoreReviewRequest $request)
    {
        $review = Review::create([
            'client_id'  => $request->user()->id,
            'service_id' => $request->service_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return $this->successResponse(new ReviewResource($review), 'Review submitted.', 201);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();

        return $this->successResponse([], 'Review deleted.');
    }
}
