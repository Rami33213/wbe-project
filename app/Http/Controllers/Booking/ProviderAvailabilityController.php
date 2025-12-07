<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreAvailableSlotRequest;
use App\Services\Booking\AvailabilityService;
use Illuminate\Support\Facades\Auth;

class ProviderAvailabilityController extends Controller
{
    public function __construct(protected AvailabilityService $availabilityService) {}

    public function addSlot(StoreAvailableSlotRequest $request)
    {
        return $this->availabilityService->addSlot(Auth::id(), $request->validated());
    }

    public function getSlots()
    {
        return $this->availabilityService->getSlots(Auth::id());
    }

    public function deleteSlot($id)
    {
        return $this->availabilityService->deleteSlot(Auth::id(), $id);
    }
}