<?php

namespace App\Services\Customer;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerProviderSearchService
{
    public function searchProviders(Request $request)
    {
        $query = User::with(['providerProfile', 'services', 'reviews'])
            ->where('role', 'provider');

        // ✅ فلترة حسب المدينة
        if ($request->filled('city')) {
            $query->where('location_city', $request->city);
        }

        // ✅ فلترة حسب المنطقة
        if ($request->filled('area')) {
            $query->where('location_area', $request->area);
        }

        // ✅ فلترة حسب نوع الخدمة
        if ($request->filled('category_id')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        // ✅ فلترة حسب السعر
        if ($request->filled('price_min')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('price_min', '>=', $request->price_min);
            });
        }

        if ($request->filled('price_max')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('price_max', '<=', $request->price_max);
            });
        }

        return response()->json([
            'providers' => $query->paginate(20)
        ]);
    }
}
