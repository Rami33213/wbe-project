<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddCategoryRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return ['name' => 'required|string|max:255'];
    }
}