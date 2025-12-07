<?php

namespace App\Services\Admin;

use App\Models\ServiceCategory;

class CategoryService
{
    public function all()
    {
        return response()->json(ServiceCategory::all(), 200);
    }

    public function create(array $data)
    {
        $category = ServiceCategory::create($data);
        return response()->json(['message' => 'Category created', 'category' => $category], 201);
    }

    public function update($id, array $data)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->update($data);
        return response()->json(['message' => 'Category updated', 'category' => $category], 200);
    }

    public function delete($id)
    {
        ServiceCategory::findOrFail($id)->delete();
        return response()->json(['message' => 'Category deleted'], 200);
    }
}