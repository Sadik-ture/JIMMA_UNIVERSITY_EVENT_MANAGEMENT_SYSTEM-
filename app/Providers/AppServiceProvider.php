<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Announcement;
use App\Policies\AnnouncementPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Announcement::class => AnnouncementPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}