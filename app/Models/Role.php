<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // Relationship with users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relationship with permissions
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}