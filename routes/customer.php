<?php

use App\Http\Controllers\Booking\CustomerBookingController;
use App\Http\Controllers\Review\CustomerReviewController;
use App\Http\Controllers\Services\CustomerServiceController;
use App\Http\Controllers\Customer\CustomerProviderSearchController;

use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'role:customer'])->prefix('customer')->group(function () {

    Route::get('/bookings', [CustomerBookingController::class, 'myBookings']);
    Route::post('/bookings', [CustomerBookingController::class, 'store']);
    Route::patch('/bookings/{id}/cancel', [CustomerBookingController::class, 'cancelBooking']);
    Route::post('/reviews/{bookingId}', [CustomerReviewController::class, 'store']);

    Route::get('/bookings/{id}', [CustomerBookingController::class, 'show']);
    Route::get('/services/{id}', [CustomerServiceController::class, 'show']);
    Route::get('/reviews', [CustomerReviewController::class, 'myReviews']);
    Route::get('/notifications', [CustomerBookingController::class, 'notifications']);

    Route::get('/providers/search', [CustomerProviderSearchController::class, 'search']);

});
