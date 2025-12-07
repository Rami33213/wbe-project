<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'location_city' => 'nullable|string|max:100',
            'location_area' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6',
        ];
    }
}