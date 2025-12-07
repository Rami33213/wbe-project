<?php
namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Services\Booking\BookingService;
use Illuminate\Support\Facades\Auth;

class CustomerBookingController extends Controller
{
    public function __construct(protected BookingService $bookingService) {}

    public function store(StoreBookingRequest $request)
    {
        return $this->bookingService->createBooking(Auth::id(), $request->validated());
    }

    public function myBookings()
    {
        return $this->bookingService->getCustomerBookings(Auth::id());
    }

    public function cancelBooking($id)
    {
        return $this->bookingService->cancelBooking(Auth::id(), $id);
    }

    public function show($id)
    {
        return $this->bookingService->getCustomerBookingDetails(Auth::id(), $id); // لازم تضيفي هالميثود بالـ BookingService
    }

    public function notifications()
    {
        // اختياري: إذا عندك جدول notifications أو عم تستخدمي Laravel Notifications
        return response()->json([
            'notifications' => Auth::user()->notifications()->latest()->take(20)->get()
        ]);
    }
}