<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'data',
        'priority',
        'event_id',
        'sender_id',
        'recipient_type',
        'recipient_ids',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'data' => 'array',
        'recipient_ids' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_notifications')
            ->withPivot(['read', 'read_at', 'email_sent', 'email_sent_at'])
            ->withTimestamps();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->whereNull('sent_at');
    }

    public function scopeSent($query)
    {
        return $query->whereNotNull('sent_at');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    // Methods
    public function markAsSent()
    {
        $this->update(['sent_at' => now()]);
    }

    public function isSent(): bool
    {
        return !is_null($this->sent_at);
    }

    public function getStatusAttribute(): string
    {
        if ($this->isSent()) return 'sent';
        if ($this->scheduled_at) return 'scheduled';
        return 'pending';
    }
}