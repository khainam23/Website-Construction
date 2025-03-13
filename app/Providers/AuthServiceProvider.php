<?php

namespace App\Providers;

use App\Models\Device;
use App\Policies\DevicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Device::class => DevicePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
