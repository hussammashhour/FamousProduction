<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\FaqResource;

class FaqgableController extends Controller
{
    use ApiResponseTrait;

    public function syncServiceFaqs(Request $request, Service $service)
    {
        $request->validate([
            'faq_ids' => ['required', 'array'],
            'faq_ids.*' => ['exists:faqs,id'],
        ]);

        $service->faqs()->sync($request->faq_ids);

        return $this->successResponse([], 'FAQs synced to service.');
    }

    public function getServiceFaqs(Service $service)
    {
        return $this->successResponse(
            FaqResource::collection($service->faqs),
            'FAQs for service retrieved.'
        );
    }

    public function syncRoleFaqs(Request $request, Role $role)
    {
        $request->validate([
            'faq_ids' => ['required', 'array'],
            'faq_ids.*' => ['exists:faqs,id'],
        ]);

        $role->faqs()->sync($request->faq_ids);

        return $this->successResponse([], 'FAQs synced to role.');
    }

    public function getRoleFaqs(Role $role)
    {
        return $this->successResponse(
            FaqResource::collection($role->faqs),
            'FAQs for role retrieved.'
        );
    }
}
