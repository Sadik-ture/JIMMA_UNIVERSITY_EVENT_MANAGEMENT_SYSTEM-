<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'venue',
        'campus',
        'event_type',
        'organizer',
        'contact_email',
        'contact_phone',
        'featured_image',
        'max_attendees',
        'registered_attendees',
        'is_featured',
        'is_public',
        'requires_registration',
        'registration_link',
        'tags',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'requires_registration' => 'boolean',
        'tags' => 'array',
        'max_attendees' => 'integer',
        'registered_attendees' => 'integer',
    ];

    // Accessor for status
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                $now = now();
                if ($this->start_date > $now) {
                    return 'upcoming';
                } elseif ($this->start_date <= $now && $this->end_date >= $now) {
                    return 'ongoing';
                } else {
                    return 'past';
                }
            }
        );
    }

    // Accessor for available seats
    protected function availableSeats(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->max_attendees) {
                    return null;
                }
                return $this->max_attendees - $this->registered_attendees;
            }
        );
    }

    // Scope for upcoming events
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())
                     ->where('is_public', true)
                     ->orderBy('start_date');
    }

    // Scope for ongoing events
    public function scopeOngoing($query)
    {
        $now = now();
        return $query->where('start_date', '<=', $now)
                     ->where('end_date', '>=', $now)
                     ->where('is_public', true)
                     ->orderBy('start_date');
    }

    // Scope for past events
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now())
                     ->where('is_public', true)
                     ->orderBy('start_date', 'desc');
    }

    // Scope for featured events
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->where('is_public', true);
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('venue', 'like', "%{$search}%")
              ->orWhere('campus', 'like', "%{$search}%")
              ->orWhere('organizer', 'like', "%{$search}%");
        });
    }

    // Check if event is full
    public function isFull(): bool
    {
        if (!$this->max_attendees) {
            return false;
        }
        return $this->registered_attendees >= $this->max_attendees;
    }

    // Get event duration in hours
    public function getDurationAttribute(): float
    {
        return $this->start_date->diffInHours($this->end_date);
    }

    // Get event type color
    public function getTypeColorAttribute(): string
    {
        $colors = [
            'academic' => 'primary',
            'cultural' => 'success',
            'sports' => 'warning',
            'conference' => 'info',
            'workshop' => 'danger',
            'seminar' => 'secondary',
        ];

        return $colors[$this->event_type] ?? 'secondary';
    }


    // Add this to the Event model
public function speakers()
{
    return $this->belongsToMany(Speaker::class, 'event_speaker')
                ->withPivot('session_title', 'session_time', 'session_duration', 'session_description', 'order', 'is_keynote')
                ->withTimestamps()
                ->orderBy('order');
}

// Get keynote speakers
public function keynoteSpeakers()
{
    return $this->speakers()->wherePivot('is_keynote', true);
}

// Get regular speakers
public function regularSpeakers()
{
    return $this->speakers()->wherePivot('is_keynote', false);
}

// Get speakers grouped by session
public function getSpeakersBySession()
{
    return $this->speakers()
        ->get()
        ->groupBy(function ($speaker) {
            return $speaker->pivot->session_time 
                ? $speaker->pivot->session_time->format('Y-m-d H:i') 
                : 'unscheduled';
        });
}

// In Event.php model
public function setTagsAttribute($value)
{
    if (is_string($value)) {
        $this->attributes['tags'] = json_encode(
            array_map('trim', explode(',', $value))
        );
    } elseif (is_array($value)) {
        $this->attributes['tags'] = json_encode($value);
    } else {
        $this->attributes['tags'] = null;
    }
}

public function getTagsAttribute($value)
{
    if (is_string($value)) {
        return json_decode($value, true);
    }
    
    return $value;
}

}

