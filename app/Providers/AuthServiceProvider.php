<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    // protected $policies = [
    //     // Model::class => Policy::class,
    // ];

    // app/Providers/AuthServiceProvider.php
protected $policies = [
    // \App\Models\Feedback::class => \App\Policies\FeedbackPolicy::class,
    \App\Models\Feedback::class => \App\Policies\FeedbackPolicy::class,

];

    public function boot(): void
    {
        $this->registerPolicies();

        // Super admin bypasses all permissions
        Gate::before(function ($user, $ability) {
            if ($user->role && $user->role->slug === 'super-admin') {
                return true;
            }
        });

        // Define gates for notification permissions
        Gate::define('view_notifications', function ($user) {
            return $user->hasPermission('view_notifications');
        });

        Gate::define('send_notifications', function ($user) {
            return $user->hasPermission('send_notifications');
        });

        Gate::define('manage_notifications', function ($user) {
            return $user->hasPermission('manage_notifications');
        });

        Gate::define('send_custom_notification', function ($user) {
            return $user->hasPermission('send_custom_notification');
        });

        // Define other gates as needed
        $permissions = \App\Models\Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->hasPermission($permission->slug);
            });
        }
    }
}