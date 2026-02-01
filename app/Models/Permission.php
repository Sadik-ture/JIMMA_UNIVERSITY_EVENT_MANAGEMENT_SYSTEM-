<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function roles(): BelongsToMany
    {
        // FIX: Explicitly define the pivot table name
        return $this->belongsToMany(Role::class, 'role_permission')
                    ->withTimestamps();
    }
}