<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    // Relationship with role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Check if user has a specific permission
    public function hasPermission($permissionSlug)
    {
        // If user doesn't have a role, return false
        if (!$this->role) {
            return false;
        }
        
        // If user is super admin, they have all permissions
        if ($this->role->slug === 'super-admin') {
            return true;
        }
        
        // Check if role has the permission
        return $this->role->permissions()->where('slug', $permissionSlug)->exists();
    }

    // Check if user has any of the given permissions
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

    // Check if user has a specific role
    public function hasRole($roleSlug)
    {
        if (!$this->role) {
            return false;
        }
        
        return $this->role->slug === $roleSlug;
    }
}