<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\UpdateBookingStatusRequest;
use App\Services\Booking\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderBookingController extends Controller
{
    public function __construct(protected BookingService $bookingService) {}

    public function providerBookings()
    {
        return $this->bookingService->getProviderBookings(Auth::id());
    }

    public function updateStatus(UpdateBookingStatusRequest $request, $id)
{
    $data = $request->validated();
    $status = $data['status'];
    $reason = $data['reason'] ?? null;

    return $this->bookingService->updateBookingStatus(
        Auth::id(),
        $id,
        $status,
        $reason
    );
}

    
}