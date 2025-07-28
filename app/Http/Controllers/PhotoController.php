<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use App\Traits\ApiResponseTrait;

class PhotoController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $photos = Photo::with('post')->latest()->paginate(10);
        return $this->successResponse(PhotoResource::collection($photos), 'Photos retrieved successfully.');
    }

    public function store(StorePhotoRequest $request)
    {
        // Store image under storage/app/public/photos
        $imagePath = $request->file('image')->store('photos', 'public');
         $photo = Photo::create([
        'post_id' => $request->post_id,
        'caption' => $request->caption,
        'image_url' => 'storage/' . $imagePath, // keep using `image_url` field as a file path
    ]);

    return $this->successResponse(new PhotoResource($photo), 'Photo uploaded successfully.', 201);
    }

    public function show(Photo $photo)
    {
        return $this->successResponse(new PhotoResource($photo), 'Photo retrieved successfully.');
    }

    public function update(StorePhotoRequest $request, Photo $photo)
    {
         $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('photos', 'public');
            $data['image_url'] = 'storage/' . $imagePath;
        }

        $photo->update($data);

        return $this->successResponse(new PhotoResource($photo), 'Photo updated successfully.');
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        return $this->successResponse([], 'Photo deleted successfully.');
    }
}
