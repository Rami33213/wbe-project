<?php

use App\Http\Controllers\Review\PublicReviewController;
use App\Http\Controllers\Provider\PublicProviderController;
use App\Http\Controllers\Services\CustomerServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/services', [CustomerServiceController::class, 'index']);
Route::get('/providers/{id}', [PublicProviderController::class, 'show']);
Route::get('/reviews/service/{id}', [PublicReviewController::class, 'reviewsForService']);
Route::get('/reviews/provider/{id}', [PublicReviewController::class, 'reviewsForProvider']);