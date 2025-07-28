<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return $this->successResponse(AnnouncementResource::collection($announcements), 'Announcements retrieved.');
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $announcement = Announcement::create([
            ...$request->validated(),
            'created_by' => $request->user()->id,
        ]);

        return $this->successResponse(new AnnouncementResource($announcement), 'Announcement created.', 201);
    }

    public function show(Announcement $announcement)
    {
        return $this->successResponse(new AnnouncementResource($announcement), 'Announcement details retrieved.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return $this->successResponse([], 'Announcement deleted.');
    }
}
