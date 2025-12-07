<?php

use App\Http\Controllers\Booking\ProviderBookingController;
use App\Http\Controllers\Booking\ProviderAvailabilityController;
use App\Http\Controllers\Provider\ProviderProfileController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:provider'])->prefix('provider')->group(function () {
    Route::get('/bookings', [ProviderBookingController::class, 'providerBookings']);
    Route::patch('/bookings/{id}/status', [ProviderBookingController::class, 'updateStatus']);
    Route::post('/availability', [ProviderAvailabilityController::class, 'addSlot']);
    Route::get('/availability', [ProviderAvailabilityController::class, 'getSlots']);
    Route::delete('/availability/{id}', [ProviderAvailabilityController::class, 'deleteSlot']);
    Route::patch('/profile', [ProviderProfileController::class, 'update']);
    Route::patch('/services', [ProviderProfileController::class, 'updateServices']);
    Route::patch('/bookings/{id}/status', [ProviderBookingController::class, 'updateStatus']);

});