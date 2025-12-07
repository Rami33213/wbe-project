<?php

namespace App\Services\Admin;

use App\Models\User;

class UserService
{
    public function all()
    {
        return response()->json(User::all(), 200);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'suspended' : 'active';
        $user->save();

        return response()->json(['message' => 'User status updated', 'user' => $user], 200);
    }

    public function providers()
    {
        return response()->json(User::where('role', 'provider')->get(), 200);
    }

    public function toggleProviderStatus($id)
    {
        $provider = User::where('role', 'provider')->findOrFail($id);
        $provider->status = $provider->status === 'active' ? 'suspended' : 'active';
        $provider->save();

        return response()->json(['message' => 'Provider status updated', 'provider' => $provider], 200);
    }

    public function deleteProvider($id)
    {
        $provider = User::where('role', 'provider')->findOrFail($id);
        $provider->delete();

        return response()->json(['message' => 'Provider deleted successfully'], 200);
    }
}