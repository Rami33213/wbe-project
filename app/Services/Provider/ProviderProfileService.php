<?php

namespace App\Services\Provider;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProviderProfileService
{
    /**
     * عرض الملف العام للمزوّد
     */
public function getOwnProfile(): \Illuminate\Http\JsonResponse
{
    /** @var User $provider */
    $provider = auth()->user();

    $profile = $provider->providerProfile;

    if (!$profile) {
        return response()->json([
            'profile' => [
                'bio' => null,
                'years_of_experience' => null,
                'base_price' => null,
                'covered_areas' => [],
                'is_available' => true,
            ]
        ], 200);
    }

    return response()->json([
        'profile' => [
            'bio' => $profile->bio,
            'years_of_experience' => $profile->years_of_experience,
            'base_price' => $profile->base_price,
            'covered_areas' => $profile->covered_areas
                ? json_decode($profile->covered_areas, true)
                : [],
            'is_available' => $profile->is_available,
        ]
    ], 200);
}

      public function listServices(): JsonResponse
    {
        /** @var User $provider */
        $provider = auth()->user();

        $services = $provider->services()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'services' => $services,
        ], 200);
    }
    public function getPublicProfile($id): JsonResponse
    {
        $provider = User::with([
            'providerProfile',
            'services.category',
            'reviews.customer',
            'bookings' => fn($q) => $q->whereIn('status', ['confirmed', 'completed'])
        ])
        ->where('role', 'provider')
        ->where('status', 'active')
        ->find($id);

        if (!$provider) {
            return response()->json(['message' => 'المزود غير موجود أو غير مفعل'], 404);
        }

        $averageRating = $provider->reviews->avg('rating') ?? 0;
        $totalBookings = $provider->bookings->count();

        return response()->json([
            'provider' => [
                'id' => $provider->id,
                'name' => $provider->name,
                'email' => $provider->email,
                'phone' => $provider->phone,
                'location_city' => $provider->location_city,
                'location_area' => $provider->location_area,

                // ✅ بيانات البروفايل
                'bio' => $provider->providerProfile->bio ?? null,
                'years_of_experience' => $provider->providerProfile->years_of_experience ?? null,
                'base_price' => $provider->providerProfile->base_price ?? null,
                'covered_areas' => $provider->providerProfile->covered_areas
                    ? json_decode($provider->providerProfile->covered_areas, true)
                    : [],

                'is_available' => $provider->providerProfile->is_available ?? true,

                // ✅ خدمات + تقييمات
                'services' => $provider->services,
                'reviews' => $provider->reviews,
                'average_rating' => round($averageRating, 2),
                'total_bookings' => $totalBookings,
            ]
        ]);
    }

    /**
     * تعديل الملف الشخصي للمزوّد
     */
    public function updateProfile(Request $request): JsonResponse
    {
        /** @var User $provider */
        $provider = auth()->user();

        $profile = $provider->providerProfile()->updateOrCreate(
            ['user_id' => $provider->id],
            [
                'bio' => $request->bio,
                'years_of_experience' => $request->years_of_experience,
                'base_price' => $request->base_price,

                // ✅ تخزين JSON بشكل صحيح
                'covered_areas' => is_array($request->covered_areas)
                    ? json_encode($request->covered_areas)
                    : $request->covered_areas,

                'is_available' => $request->is_available,
            ]
        );

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $profile
        ]);
    }

    /**
     * تعديل خدمات المزوّد (التخصصات)
     */
    public function updateServices(Request $request): JsonResponse
    {
        /** @var User $provider */
        $provider = auth()->user();

        $request->validate([
            'services' => 'required|array',

            // ✅ إذا الخدمة موجودة → لازم id صحيح
            'services.*.id' => 'nullable|exists:services,id',

            // ✅ اسم الخدمة مطلوب
            'services.*.name' => 'required|string|max:255',

            // ✅ جدولك اسمه service_categories
            'services.*.category_id' => 'required|exists:service_categories,id',

            'services.*.price_min' => 'required|numeric|min:0',
            'services.*.price_max' => 'required|numeric|min:0',
            'services.*.description' => 'nullable|string|max:500',
        ]);

        foreach ($request->services as $serviceData) {
            $provider->services()->updateOrCreate(
                ['id' => $serviceData['id'] ?? null],
                [
                    'name' => $serviceData['name'],
                    'category_id' => $serviceData['category_id'],
                    'price_min' => $serviceData['price_min'],
                    'price_max' => $serviceData['price_max'],
                    'description' => $serviceData['description'] ?? null,
                ]
            );
        }

        return response()->json([
            'message' => 'Services updated successfully',
            'services' => $provider->services()->with('category')->get()
        ]);
    }
}
