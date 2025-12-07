<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Services\Review\ReviewService;
use Illuminate\Http\JsonResponse;

class PublicReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * 🟢 عرض مراجعات خدمة معينة
     */
    public function reviewsForService($id): JsonResponse
    {
        return $this->reviewService->getReviewsForService($id);
    }

    /**
     * 🟢 عرض مراجعات مزود معين
     */
    public function reviewsForProvider($id): JsonResponse
    {
        return $this->reviewService->getReviewsForProvider($id);
    }
}