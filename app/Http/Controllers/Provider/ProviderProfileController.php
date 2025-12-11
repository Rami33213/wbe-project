<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\UpdateProviderProfileRequest;
use App\Services\Provider\ProviderProfileService;
use Symfony\Component\HttpFoundation\Request;

class ProviderProfileController extends Controller
{
    public function __construct(protected ProviderProfileService $profileService) {}

    public function update(UpdateProviderProfileRequest $request)
    {
        return $this->profileService->updateProfile($request);
    }

    // ✅ جديد: ترجع خدمات المزوّد الحالي
    public function listServices()
    {
        return $this->profileService->listServices();
    }

    public function updateServices(Request $request)
    {
        return $this->profileService->updateServices($request);
    }
}
