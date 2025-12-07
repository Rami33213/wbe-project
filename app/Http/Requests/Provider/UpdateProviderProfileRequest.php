<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bio' => 'nullable|string|max:500',
            'years_of_experience' => 'nullable|integer|min:0|max:50',
            'base_price' => 'nullable|numeric|min:0',
            'covered_areas' => 'nullable|array',
            'is_available' => 'nullable|boolean',
        ];
    }
}
