<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Waitlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'position',
        'joined_at',
        'notified_at',
        'converted_at',
        'notes'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'converted_at' => 'datetime',
        'notified_at' => 'datetime',
    ];

    // Relationships
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereNull('converted_at');
    }

    public function scopeConverted($query)
    {
        return $query->whereNotNull('converted_at');
    }

    public function scopeNotified($query)
    {
        return $query->whereNotNull('notified_at');
    }

    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Helper methods
    public function markAsConverted()
    {
        $this->update(['converted_at' => now()]);
    }

    public function markAsNotified()
    {
        $this->update(['notified_at' => now()]);
    }

    public function isActive()
    {
        return is_null($this->converted_at);
    }
}