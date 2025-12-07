<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Services\Review\ReviewService;
use Illuminate\Support\Facades\Auth;

class CustomerReviewController extends Controller
{
    public function __construct(protected ReviewService $reviewService) {}

    public function store(StoreReviewRequest $request, $bookingId)
    {
        return $this->reviewService->storeReview(Auth::id(), $bookingId, $request->validated());
    }

    public function myReviews()
    {
        return $this->reviewService->getReviewsByCustomer(Auth::id()); // لازم تضيفي هالميثود بالـ ReviewService
    }
}