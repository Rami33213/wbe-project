<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true; // أو logic حسب حمايتك
    }

    public function rules()
    {
        return [
            'status' => 'required|in:pending,confirmed,completed,rejected,cancelled',
            'reason' => 'nullable|string|max:255',
        ];
    }
}
