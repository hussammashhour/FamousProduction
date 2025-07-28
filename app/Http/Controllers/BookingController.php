<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Notifications\BookingConfirmed;

class BookingController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $user = $request->user();

        $bookings = Booking::where('client_id', $user->id)
            ->orWhere('photographer_id', $user->id)
            ->with('service')
            ->latest()
            ->paginate(10);
            //confirm the reservation
       // $user->notify(new BookingConfirmed($booking));

        return $this->successResponse(BookingResource::collection($bookings), 'Bookings retrieved successfully.');
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create($request->validated());

        return $this->successResponse(new BookingResource($booking), 'Booking created successfully.', 201);
    }

    public function show(Booking $booking)
    {
        return $this->successResponse(new BookingResource($booking->load('service')), 'Booking retrieved successfully.');
    }

    public function update(StoreBookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());

        return $this->successResponse(new BookingResource($booking), 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return $this->successResponse([], 'Booking cancelled successfully.');
    }
}
