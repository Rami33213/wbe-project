<?php

namespace App\Services\Booking;

use App\Models\Booking;
use App\Models\BookingLog;
use App\Notifications\SimpleNotification;

class BookingService
{
    public function getAllBookings()
    {
        return Booking::with(['customer','provider','service','logs','review'])
            ->orderBy('date', 'desc')
            ->get();
    }

    public function createBooking($customerId, array $data)
    {
        $booking = Booking::create([
            'customer_id' => $customerId,
            'provider_id' => $data['provider_id'],
            'service_id'  => $data['service_id'],
            'date'        => $data['date'],
            'start_time'  => $data['start_time'],
            'end_time'    => $data['end_time'] ?? null,
            'status'      => 'pending',
            'notes'       => $data['notes'] ?? null,
        ]);

        if ($booking->provider) {
            $booking->provider->notify(
                new SimpleNotification("📅 حجز جديد بانتظارك رقم #{$booking->id}")
            );
        }

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ], 201);
    }

    public function getCustomerBookings($customerId)
    {
        $bookings = Booking::with(['provider', 'service'])
            ->where('customer_id', $customerId)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json(['bookings' => $bookings], 200);
    }

    public function getProviderBookings($providerId)
    {
        $bookings = Booking::with(['customer', 'service'])
            ->where('provider_id', $providerId)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json(['bookings' => $bookings], 200);
    }

    public function updateBookingStatus($providerId, $bookingId, $newStatus)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('provider_id', $providerId)
            ->with(['customer'])
            ->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found or not assigned to this provider'], 404);
        }

        $oldStatus = $booking->status;

        $booking->update(['status' => $newStatus]);

        BookingLog::create([
            'booking_id' => $booking->id,
            'changed_by' => $providerId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);

        if ($booking->customer) {
            $booking->customer->notify(
                new SimpleNotification("🔔 تم تغيير حالة حجزك رقم #{$booking->id} من {$oldStatus} إلى {$newStatus}")
            );
        }

        return response()->json([
            'message' => 'Booking status updated successfully',
            'booking' => $booking
        ], 200);
    }


    public function cancelBooking($customerId, $bookingId)
{
    $booking = Booking::where('id', $bookingId)
        ->where('customer_id', $customerId)
        ->first();

    if (!$booking) {
        return response()->json(['message' => 'الحجز غير موجود أو لا يخصك'], 404);
    }

    if (!in_array($booking->status, ['pending', 'confirmed'])) {
        return response()->json(['message' => 'لا يمكن إلغاء هذا الحجز في حالته الحالية'], 400);
    }

    // تحقق من أن الموعد لم يبدأ بعد
    $now = now();
    $bookingDateTime = $booking->date . ' ' . $booking->start_time;
    if ($now->gt(\Carbon\Carbon::parse($bookingDateTime)->subHours(2))) {
        return response()->json(['message' => 'لا يمكن الإلغاء قبل أقل من ساعتين من الموعد'], 400);
    }

    $booking->update(['status' => 'cancelled']);

    return response()->json(['message' => 'تم إلغاء الحجز بنجاح', 'booking' => $booking], 200);
}


public function getCustomerBookingDetails($customerId, $bookingId)
{
    $booking = Booking::with(['provider', 'service', 'review', 'logs'])
        ->where('id', $bookingId)
        ->where('customer_id', $customerId)
        ->first();

    if (!$booking) {
        return response()->json(['message' => 'الحجز غير موجود أو لا يخصك'], 404);
    }

    return response()->json(['booking' => $booking], 200);
}
}