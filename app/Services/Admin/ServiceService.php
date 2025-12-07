<?php

namespace App\Services\Admin;

use App\Models\Service;

class ServiceService
{

    public function show($id)
{
    $service = Service::with(['provider', 'category'])->find($id);

    if (!$service) {
        return response()->json(['message' => 'service not found'], 404);
    }

    return response()->json(['service' => $service], 200);
}
    public function all()
    {
        return response()->json(Service::with(['provider','category'])->get(), 200);
    }

    public function create(array $data)
    {
        $service = Service::create($data);
        return response()->json(['message' => 'Service created', 'service' => $service], 201);
    }

    public function update($id, array $data)
    {
        $service = Service::findOrFail($id);
        $service->update($data);
        return response()->json(['message' => 'Service updated', 'service' => $service], 200);
    }

    public function delete($id)
    {
        Service::findOrFail($id)->delete();
        return response()->json(['message' => 'Service deleted'], 200);
    }


    public function filterForCustomer($request)
{
    $query = \App\Models\Service::with(['provider', 'category'])->where('is_active', true);

    if ($request->filled('city')) {
        $query->whereHas('provider', function ($q) use ($request) {
            $q->where('location_city', $request->city);
        });
    }

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->filled('price_min')) {
        $query->where('price_min', '>=', $request->price_min);
    }

    if ($request->filled('price_max')) {
        $query->where('price_max', '<=', $request->price_max);
    }

    return response()->json([
        'services' => $query->orderBy('created_at', 'desc')->paginate(20)
    ]);
}
}