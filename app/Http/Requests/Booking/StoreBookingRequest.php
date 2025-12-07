<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'provider_id' => 'required|exists:users,id',
            'service_id'  => 'required|exists:services,id',
            'date'        => 'required|date',
            'start_time'  => 'required',
            'end_time'    => 'nullable',
            'notes'       => 'nullable|string',
        ];
    }
}