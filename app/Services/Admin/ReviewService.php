<?php

namespace App\Services\Admin;

use App\Models\Review;

class ReviewService
{
    public function all()
    {
        return response()->json(
            Review::with(['customer','provider','service'])->get(),
            200
        );
    }

    public function delete($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted'], 200);
    }
}