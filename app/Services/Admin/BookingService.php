<?php

namespace App\Services\Admin;

use App\Models\Booking;

class BookingService
{
    public function report()
    {
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status','pending')->count(),
            'accepted' => Booking::where('status','accepted')->count(),
            'rejected' => Booking::where('status','rejected')->count(),
            'cancelled' => Booking::where('status','cancelled')->count(),
        ];

        $bookings = Booking::with(['customer','provider','service'])
            ->orderBy('date','desc')
            ->get();

             return response()->json([
            'stats' => $stats,
            'bookings' => $bookings
        ], 200);
    }
}