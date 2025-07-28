<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::query()->where('is_active', true);

        // Filter by model type and id
        if ($request->has(['faqable_type', 'faqable_id'])) {
            $query->whereHasMorph(
                'faqables',
                [$request->faqable_type],
                function ($q) use ($request) {
                    $q->where('faqable_id', $request->faqable_id);
                }
            );
        }

        return FaqResource::collection($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'is_active' => 'boolean',
            'faqable_type' => 'required|string',
            'faqable_id' => 'required|integer',
        ]);

        $faq = Faq::create($request->only(['question', 'answer', 'is_active']));
        $faq->faqables()->attach([
            $request->faqable_id => ['faqable_type' => $request->faqable_type],
        ]);

        return new FaqResource($faq);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return response()->json(['message' => 'FAQ deleted']);
    }
}
