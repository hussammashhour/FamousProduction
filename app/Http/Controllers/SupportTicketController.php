<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Http\Requests\StoreSupportTicketRequest;
use App\Http\Resources\SupportTicketResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $tickets = SupportTicket::with(['replies', 'attachments'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return $this->successResponse(SupportTicketResource::collection($tickets), 'Tickets retrieved.');
    }

    public function store(StoreSupportTicketRequest $request)
    {
        $ticket = SupportTicket::create([
            'user_id'    => $request->user()->id,
            'subject'    => $request->subject,
            'description'=> $request->description,
            'priority'   => $request->priority,
            'status'     => 'open',
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $ticket->attachments()->create([
                    'file_path'     => $file->store('attachments', 'public'),
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type'     => $file->getClientMimeType(),
                ]);
            }
        }

        return $this->successResponse(new SupportTicketResource($ticket->load('attachments')), 'Ticket created.', 201);
    }

    public function close(SupportTicket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return $this->successResponse(new SupportTicketResource($ticket), 'Ticket closed.');
    }
}
