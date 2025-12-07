<?php 

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price_min' => 'sometimes|numeric|min:0',
            'price_max' => 'sometimes|numeric|min:0',
            'duration_minutes' => 'sometimes|integer|min:1',
            'provider_id' => 'sometimes|exists:users,id',
            'category_id' => 'sometimes|exists:service_categories,id',
            'is_active' => 'boolean'
        ];
    }
}