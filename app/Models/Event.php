<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'start_date',
        'end_date',
        'campus_id',
        'building_id',
        'venue_id',
        'campus',
        'building',
        'venue',
        'event_type',
        'organizer',
        'contact_email',
        'contact_phone',
        'max_attendees',
        'registered_attendees',
        'is_featured',
        'is_public',
        'requires_registration',
        'registration_link',
        'tags',
        'image',
        'status',
        'additional_venue_info'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'requires_registration' => 'boolean',
        'tags' => 'array',
        'additional_venue_info' => 'array',
        'max_attendees' => 'integer',
        'registered_attendees' => 'integer'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
                $counter = 1;
                while (static::where('slug', $event->slug)->exists()) {
                    $event->slug = Str::slug($event->title) . '-' . $counter;
                    $counter++;
                }
            }
        });
    }

    /**
     * Get the campus that owns the event.
     */
    public function campusRelation()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    /**
     * Get the building that owns the event.
     */
    public function buildingRelation()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * Get the venue that owns the event.
     */
    public function venueRelation()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    /**
     * Get event registrations.
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get waitlists.
     */
    public function waitlists()
    {
        return $this->hasMany(Waitlist::class);
    }

    /**
     * Check if current user is registered for this event.
     */
    public function isRegisteredByUser($userId = null)
    {
        if (!$userId && Auth::check()) {
            $userId = Auth::id();
        }
        
        if (!$userId) {
            return false;
        }
        
        return $this->registrations()
            ->where('user_id', $userId)
            ->whereIn('status', ['confirmed', 'pending'])
            ->exists();
    }

    /**
     * Check if current user is on waitlist for this event.
     */
    public function isOnWaitlistByUser($userId = null)
    {
        if (!$userId && Auth::check()) {
            $userId = Auth::id();
        }
        
        if (!$userId) {
            return false;
        }
        
        return $this->waitlists()
            ->where('user_id', $userId)
            ->whereNull('converted_at')
            ->exists();
    }

    /**
     * Check if event is full.
     */
    public function getIsFullAttribute()
    {
        if (!$this->max_attendees) {
            return false;
        }
        
        return $this->registered_attendees >= $this->max_attendees;
    }

    /**
     * Get available seats.
     */
    public function getAvailableSeatsAttribute()
    {
        if (!$this->max_attendees) {
            return null;
        }
        
        return max(0, $this->max_attendees - $this->registered_attendees);
    }

    /**
     * Add user to waitlist.
     */
    public function addToWaitlist($userId)
    {
        if ($this->isOnWaitlistByUser($userId)) {
            return false;
        }
        
        $position = $this->waitlists()->whereNull('converted_at')->count() + 1;
        
        return $this->waitlists()->create([
            'user_id' => $userId,
            'position' => $position,
        ]);
    }

    /**
     * Fill spots from waitlist.
     */
    public function fillFromWaitlist($spots = 1)
    {
        $movedUsers = [];
        $waitlists = $this->waitlists()
            ->whereNull('converted_at')
            ->orderBy('position')
            ->limit($spots)
            ->get();
        
        foreach ($waitlists as $waitlist) {
            // Create registration
            EventRegistration::create([
                'event_id' => $this->id,
                'user_id' => $waitlist->user_id,
                'status' => 'confirmed',
                'guest_count' => 1,
                'confirmed_at' => now(),
            ]);
            
            // Update waitlist
            $waitlist->update([
                'converted_at' => now(),
                'notified_at' => now(),
            ]);
            
            // Increment registered count
            $this->increment('registered_attendees');
            
            $movedUsers[] = $waitlist->user_id;
        }
        
        return $movedUsers;
    }

    /**
     * Get confirmed registrations.
     */
    public function confirmedRegistrations()
    {
        return $this->registrations()->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    /**
     * Scope a query to only include ongoing events.
     */
    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    /**
     * Scope a query to only include past events.
     */
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now());
    }

    /**
     * Scope a query to only include featured events.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to search in title and description.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('short_description', 'like', "%{$search}%")
              ->orWhere('organizer', 'like', "%{$search}%");
        });
    }

    /**
     * Get event status.
     */
    public function getStatusAttribute()
    {
        $now = now();
        
        if ($now < $this->start_date) {
            return 'upcoming';
        } elseif ($now >= $this->start_date && $now <= $this->end_date) {
            return 'ongoing';
        } else {
            return 'completed';
        }
    }

    /**
     * Get the formatted date range.
     */
    public function getFormattedDateRangeAttribute()
    {
        if ($this->start_date->format('Y-m-d') === $this->end_date->format('Y-m-d')) {
            return $this->start_date->format('M d, Y');
        }
        
        return $this->start_date->format('M d') . ' - ' . $this->end_date->format('M d, Y');
    }

    /**
     * Get venue name safely.
     */
    public function getVenueNameAttribute()
    {
        if ($this->venueRelation && $this->venueRelation->exists) {
            return $this->venueRelation->name;
        }
        
        if (!empty($this->venue) && is_string($this->venue)) {
            return $this->venue;
        }
        
        return 'Not specified';
    }

    /**
     * Get building name safely.
     */
    public function getBuildingNameAttribute()
    {
        if ($this->buildingRelation && $this->buildingRelation->exists) {
            return $this->buildingRelation->name;
        }
        
        if (!empty($this->building) && is_string($this->building)) {
            return $this->building;
        }
        
        return 'Not specified';
    }

    /**
     * Get campus name safely.
     */
    public function getCampusNameAttribute()
    {
        if ($this->campusRelation && $this->campusRelation->exists) {
            return $this->campusRelation->name;
        }
        
        if (!empty($this->campus) && is_string($this->campus)) {
            return $this->campus;
        }
        
        return 'Not specified';
    }

    /**
     * Get venue details safely (returns either object or string).
     */
    public function getVenueDetailsAttribute()
    {
        if ($this->venueRelation && $this->venueRelation->exists) {
            return $this->venueRelation;
        }
        
        return $this->venue;
    }

    /**
     * Get building details safely (returns either object or string).
     */
    public function getBuildingDetailsAttribute()
    {
        if ($this->buildingRelation && $this->buildingRelation->exists) {
            return $this->buildingRelation;
        }
        
        return $this->building;
    }

    /**
     * Get campus details safely (returns either object or string).
     */
    public function getCampusDetailsAttribute()
    {
        if ($this->campusRelation && $this->campusRelation->exists) {
            return $this->campusRelation;
        }
        
        return $this->campus;
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured()
    {
        $this->is_featured = !$this->is_featured;
        $this->save();
    }

    /**
     * Toggle public status.
     */
    public function togglePublic()
    {
        $this->is_public = !$this->is_public;
        $this->save();
    }

    /**
     * Check if registration is open.
     */
    public function isRegistrationOpen()
    {
        if (!$this->requires_registration) {
            return false;
        }
        
        if ($this->max_attendees && $this->registered_attendees >= $this->max_attendees) {
            return false;
        }
        
        return $this->start_date > now();
    }

    /**
     * Get remaining seats.
     */
    public function getRemainingSeatsAttribute()
    {
        if (!$this->max_attendees) {
            return null;
        }
        
        return max(0, $this->max_attendees - $this->registered_attendees);
    }

    /**
     * Get attendance percentage.
     */
    public function getAttendancePercentageAttribute()
    {
        if (!$this->max_attendees) {
            return 0;
        }
        
        return ($this->registered_attendees / $this->max_attendees) * 100;
    }

    /**
     * Get formatted tags.
     */
    public function getFormattedTagsAttribute()
    {
        if (empty($this->tags) || !is_array($this->tags)) {
            return [];
        }
        
        return array_map('trim', $this->tags);
    }

    /**
     * Get image URL.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        
        return Storage::url($this->image);
    }

    /**
     * Get event type icon.
     */
    public function getEventTypeIconAttribute()
    {
        $icons = [
            'academic' => 'graduation-cap',
            'cultural' => 'music',
            'sports' => 'futbol',
            'conference' => 'comments',
            'workshop' => 'tools',
            'seminar' => 'chalkboard-teacher'
        ];
        
        return $icons[$this->event_type] ?? 'calendar-day';
    }

    /**
     * Get event type color.
     */
    public function getEventTypeColorAttribute()
    {
        $colors = [
            'academic' => 'primary',
            'cultural' => 'success',
            'sports' => 'danger',
            'conference' => 'info',
            'workshop' => 'warning',
            'seminar' => 'dark'
        ];
        
        return $colors[$this->event_type] ?? 'secondary';
    }
}