<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestUploadController extends Controller
{
    public function info()
    {
        return response()->json([
            'message' => 'Upload endpoint ready'
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('test-uploads', 'public');

        return response()->json([
            'success' => true,
            'image_url' => asset('storage/' . $path),
        ]);
    }
}
