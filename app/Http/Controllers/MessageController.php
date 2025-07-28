<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $userId = auth()->id();

        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->paginate(10);

        return $this->successResponse(MessageResource::collection($messages), 'Messages retrieved successfully.');
    }

    public function store(StoreMessageRequest $request)
    {
        $message = Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content'     => $request->content,
        ]);

        return $this->successResponse(new MessageResource($message), 'Message sent successfully.', 201);
    }

    public function markAsRead(Message $message)
    {
        $this->authorize('markAsRead', $message);

        if (!$message->is_read) {
            $message->update([
                'is_read'  => true,
                'read_at'  => now(),
            ]);
        }

        return $this->successResponse(new MessageResource($message), 'Message marked as read.');
    }

    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        $message->delete();

        return $this->successResponse([], 'Message deleted successfully.');
    }
}
