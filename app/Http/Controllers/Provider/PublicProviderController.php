<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Services\Provider\ProviderProfileService;

class PublicProviderController extends Controller
{
    public function __construct(protected ProviderProfileService $profileService) {}

    /**
     * 🟢 عرض ملف مزود الخدمة
     */
    public function show($id)
    {
        return $this->profileService->getPublicProfile($id);
    }
}