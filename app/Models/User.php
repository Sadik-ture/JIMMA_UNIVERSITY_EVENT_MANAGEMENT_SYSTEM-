<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }
    
    public function waitlists(): HasMany
    {
        return $this->hasMany(Waitlist::class);
    }

    public function announcementViews(): HasMany
    {
        return $this->hasMany(AnnouncementView::class);
    }

    public function viewedAnnouncements()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_views')
                    ->withTimestamps();
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notifications')
                    ->withPivot('id', 'read_at', 'email_sent', 'email_sent_at', 'created_at', 'updated_at')
                    ->withTimestamps()
                    ->orderBy('user_notifications.created_at', 'desc');
    }

    public function getUnreadNotificationsCountAttribute()
    {
        return $this->userNotifications()->whereNull('read_at')->count();
    }

    public function isAdmin()
    {
        if (!$this->role) {
            return false;
        }
        
        return in_array($this->role->slug, ['super-admin', 'admin']);
    }

    // FIXED PERMISSION CHECK METHOD
    public function hasPermission($permissionSlug)
    {
        // If user doesn't have a role, return false
        if (!$this->role) {
            \Log::warning("User has no role", ['user_id' => $this->id, 'permission' => $permissionSlug]);
            return false;
        }
        
        // If user is super admin, they have all permissions
        if ($this->role->slug === 'super-admin') {
            return true;
        }
        
        // Check if role has the permission
        $hasPermission = $this->role->hasPermission($permissionSlug);
        
        \Log::info("Permission check result", [
            'user' => $this->name,
            'role' => $this->role->slug,
            'permission' => $permissionSlug,
            'has_permission' => $hasPermission
        ]);
        
        return $hasPermission;
    }

    public function hasAnyPermission($permissions)
    {
        if (!is_array($permissions)) {
            $permissions = [$permissions];
        }
        
        // If user doesn't have a role, return false
        if (!$this->role) {
            return false;
        }
        
        // If user is super admin, they have all permissions
        if ($this->role->slug === 'super-admin') {
            return true;
        }
        
        // Check each permission
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        
        return false;
    }

    public function hasRole($roleSlug)
    {
        if (!$this->role) {
            return false;
        }
        
        return $this->role->slug === $roleSlug;
    }

    public function isRegisteredForEvent($eventId)
    {
        return $this->registrations()
            ->where('event_id', $eventId)
            ->whereIn('status', ['confirmed', 'pending'])
            ->exists();
    }

    public function getConfirmedRegistrationsCountAttribute()
    {
        return $this->registrations()->confirmed()->count();
    }

    public function getActiveWaitlistsCountAttribute()
    {
        return $this->waitlists()->whereNull('converted_at')->count();
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }

    // FIXED Laravel's can() method implementation
    public function can($ability, $arguments = [])
    {
        // Check if it's a permission slug
        return $this->hasPermission($ability);
    }
}