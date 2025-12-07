<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddServiceRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_min' => 'required|numeric|min:0',
            'price_max' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'provider_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:service_categories,id',
            'is_active' => 'boolean'
        ];
    }
}