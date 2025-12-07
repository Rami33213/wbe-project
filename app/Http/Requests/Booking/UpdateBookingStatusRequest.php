<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingStatusRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'status' => 'required|in:pending,confirmed,cancelled,completed',

        ];
    }
}