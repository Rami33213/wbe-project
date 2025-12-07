<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Services\Booking\BookingService;

class AdminBookingController extends Controller
{
    public function __construct(protected BookingService $bookingService) {}

    public function index()
    {
        return $this->bookingService->getAllBookings();
    }
}