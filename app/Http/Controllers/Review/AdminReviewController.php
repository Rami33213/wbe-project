<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Services\Review\ReviewService;

class AdminReviewController extends Controller
{
    public function __construct(protected ReviewService $reviewService) {}

    /**
     * 🟢 عرض كل المراجعات (للاختبار أو الأدمن)
     */
    public function index()
    {
        return $this->reviewService->getAllReviews();
    }
}