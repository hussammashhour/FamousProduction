<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Http\Requests\StoreSupportTicketReplyRequest;
use App\Http\Resources\SupportTicketReplyResource;
use App\Traits\ApiResponseTrait;

class SupportTicketReplyController extends Controller
{
    use ApiResponseTrait;

    public function store(StoreSupportTicketReplyRequest $request, SupportTicket $ticket)
    {
        $reply = $ticket->replies()->create([
            'user_id'     => $request->user()->id,
            'message'     => $request->message,
            'is_internal' => $request->get('is_internal', false),
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $reply->attachments()->create([
                    'file_path'     => $file->store('attachments', 'public'),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type'     => $file->getClientMimeType(),
                ]);
            }
        }

        return $this->successResponse(new SupportTicketReplyResource($reply->load('attachments')), 'Reply added.', 201);
    }
}
