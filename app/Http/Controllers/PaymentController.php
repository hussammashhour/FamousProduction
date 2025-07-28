<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $payments = Payment::latest()->paginate(10);
        return $this->successResponse(PaymentResource::collection($payments), 'Payments retrieved successfully.');
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());
        return $this->successResponse(new PaymentResource($payment), 'Payment recorded successfully.', 201);
    }

    public function show(Payment $payment)
    {
        return $this->successResponse(new PaymentResource($payment), 'Payment details retrieved.');
    }

    public function update(StorePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        return $this->successResponse(new PaymentResource($payment), 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return $this->successResponse([], 'Payment deleted.');
    }
}
