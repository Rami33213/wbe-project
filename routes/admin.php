<?php


use App\Http\Controllers\Admin\AdminActionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminActionController::class, 'users']);
    Route::patch('/users/{id}/toggle-status', [AdminActionController::class, 'toggleUserStatus']);
    Route::get('/providers', [AdminActionController::class, 'providers']);
    Route::patch('/providers/{id}/toggle-status', [AdminActionController::class, 'toggleProviderStatus']);
    Route::delete('/providers/{id}', [AdminActionController::class, 'deleteProvider']);
    Route::get('/categories', [AdminActionController::class, 'categories']);
    Route::post('/categories', [AdminActionController::class, 'addCategory']);
    Route::put('/categories/{id}', [AdminActionController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [AdminActionController::class, 'deleteCategory']);
    Route::get('/services', [AdminActionController::class, 'services']);
    Route::post('/services', [AdminActionController::class, 'addService']);
    Route::put('/services/{id}', [AdminActionController::class, 'updateService']);
    Route::delete('/services/{id}', [AdminActionController::class, 'deleteService']);
    Route::get('/bookings/report', [AdminActionController::class, 'bookingReports']);
    Route::get('/reviews', [AdminActionController::class, 'reviews']);
    Route::delete('/reviews/{id}', [AdminActionController::class, 'deleteReview']);
});


