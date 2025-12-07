<?php

namespace App\Services\Review;

use App\Models\Booking;
use App\Models\Review;

class ReviewService
{

    public function getReviewsByCustomer($customerId)
{
    $reviews = Review::with(['provider', 'service', 'booking'])
        ->where('customer_id', $customerId)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json(['reviews' => $reviews], 200);
}
    
    public function getAllReviews()
    {
        return Review::with(['customer','provider','service','booking'])
            ->orderBy('created_at', 'desc')
            ->paginate(20); // 20 مراجعة بالصفحة
    }

 
    public function getReviewsForService($serviceId)
    {
        $reviews = Review::with(['customer','provider'])
            ->where('service_id', $serviceId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['reviews' => $reviews], 200);
    }


    public function getReviewsForProvider($providerId)
    {
        $reviews = Review::with(['customer','service'])
            ->where('provider_id', $providerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['reviews' => $reviews], 200);
    }

    public function storeReview($customerId, $bookingId, array $data)
    {
  
        $booking = Booking::where('id', $bookingId)
            ->where('customer_id', $customerId)
            ->first();

        if (!$booking) {
            return response()->json([
                'message' => 'هذا الحجز غير موجود أو لا يخصك'
            ], 404);
        }

        //  تحقق من أن الحجز مؤكد أو منتهي قبل السماح بالمراجعة
        if (!in_array($booking->status, ['confirmed', 'completed'])) {
            return response()->json([
                'message' => 'لا يمكنك إضافة مراجعة إلا بعد تأكيد أو إتمام الحجز'
            ], 400);
        }

        $review = Review::create([
            'booking_id'  => $booking->id,
            'customer_id' => $customerId,
            'provider_id' => $booking->provider_id,
            'service_id'  => $booking->service_id,
            'rating'      => $data['rating'],
            'comment'     => $data['comment'] ?? null,
        ]);

        return response()->json([
            'message' => 'تمت إضافة المراجعة بنجاح',
            'review'  => $review
        ], 201);
    }
}