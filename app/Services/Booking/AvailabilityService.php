<?php

namespace App\Services\Booking;

use App\Models\AvailableSlot;

class AvailabilityService
{
    public function addSlot($providerId, array $data)
    {
        $slot = AvailableSlot::create([
            'provider_id' => $providerId,
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);

        return response()->json(['message' => 'تمت إضافة الموعد بنجاح', 'slot' => $slot], 201);
    }

    public function getSlots($providerId)
    {
        $slots = AvailableSlot::where('provider_id', $providerId)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return response()->json(['slots' => $slots], 200);
    }

    public function deleteSlot($providerId, $slotId)
    {
        $slot = AvailableSlot::where('id', $slotId)
            ->where('provider_id', $providerId)
            ->first();

        if (!$slot) {
            return response()->json(['message' => 'الموعد غير موجود أو لا يخصك'], 404);
        }

        $slot->delete();

        return response()->json(['message' => 'تم حذف الموعد بنجاح'], 200);
    }
}