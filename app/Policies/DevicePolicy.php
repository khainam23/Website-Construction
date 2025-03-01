<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Device;

class DevicePolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'admin' || $user->role === 'sales';
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Device $device)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Device $device)
    {
        return $user->role === 'admin';
    }
}
