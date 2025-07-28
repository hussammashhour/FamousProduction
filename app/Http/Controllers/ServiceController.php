<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ServiceController extends Controller
{
    use ApiResponseTrait;

    public function indexweb()
    {
        $services = Service::latest()->get();
        return Inertia::render('Services', [
            'services' => $services,
        ]);
    }



    public function index()
    {
        $services = Service::latest()->paginate(10);
        return $this->successResponse(ServiceResource::collection($services), 'Services retrieved successfully.');
    }

    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->validated());
        return $this->successResponse(new ServiceResource($service), 'Service created successfully.', 201);
    }

    public function show(Service $service)
    {
        return $this->successResponse(new ServiceResource($service), 'Service retrieved successfully.');
    }

    public function update(StoreServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
        return $this->successResponse(new ServiceResource($service), 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return $this->successResponse([], 'Service deleted successfully.');
    }
}
