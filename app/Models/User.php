<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    protected $appends = ['unread_notifications_count'];

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
                    ->withPivot('id', 'read_at', 'dismissed_at', 'email_sent', 'email_sent_at', 'created_at', 'updated_at')
                    ->withTimestamps()
                    ->orderBy('user_notifications.created_at', 'desc');
    }

    public function getUnreadNotificationsCountAttribute()
    {
        // First check if dismissed_at column exists
        if (!\Schema::hasColumn('user_notifications', 'dismissed_at')) {
            return $this->userNotifications()
                ->whereNull('read_at')
                ->count();
        }
        
        return $this->userNotifications()
            ->whereNull('read_at')
            ->whereNull('dismissed_at')
            ->count();
    }

    public function isAdmin()
    {
        if (!$this->role) {
            return false;
        }
        
        return in_array($this->role->slug, ['super-admin', 'admin']);
    }

    public function hasPermission($permissionSlug)
    {
        if (!$this->role) {
            Log::warning("User has no role", ['user_id' => $this->id, 'permission' => $permissionSlug]);
            return false;
        }
        
        if ($this->role->slug === 'super-admin') {
            return true;
        }
        
        $hasPermission = $this->role->hasPermission($permissionSlug);
        
        Log::info("Permission check result", [
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
        
        if (!$this->role) {
            return false;
        }
        
        if ($this->role->slug === 'super-admin') {
            return true;
        }
        
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
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    public function getActiveWaitlistsCountAttribute()
    {
        return $this->waitlists()->whereNull('converted_at')->count();
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }

    public function can($ability, $arguments = [])
    {
        return $this->hasPermission($ability);
    }
    
    public function sendNotification($notificationData, $markAsUnread = true)
    {
        $notification = Notification::create([
            'title' => $notificationData['title'],
            'message' => $notificationData['message'],
            'type' => $notificationData['type'] ?? 'info',
            'data' => $notificationData['data'] ?? [],
            'created_by' => auth()->id() ?? null,
            'action_url' => $notificationData['action_url'] ?? null,
            'action_text' => $notificationData['action_text'] ?? null,
            'priority' => $notificationData['priority'] ?? 0,
            'is_public' => $notificationData['is_public'] ?? false,
        ]);
        
        $this->notifications()->attach($notification->id, [
            'read_at' => $markAsUnread ? null : now(),
        ]);
        
        if ($notificationData['send_email'] ?? false) {
            $this->sendEmailNotification($notification);
        }
        
        return $notification;
    }
    
    private function sendEmailNotification($notification)
    {
        Log::info('Email notification would be sent', [
            'user' => $this->email,
            'notification' => $notification->title
        ]);
    }
}