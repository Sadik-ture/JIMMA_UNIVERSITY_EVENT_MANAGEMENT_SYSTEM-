<?php
// app/Models/Event.php - COMPLETE FIXED VERSION

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
        'additional_venue_info',
        'views_count',
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
        'registered_attendees' => 'integer',
        'views_count' => 'integer',
    ];

    protected $appends = [
        'image_url',
        'formatted_date_range',
        'is_full',
        'available_seats',
        'attendance_percentage',
        'remaining_seats',
        'status',
        'venue_name',
        'building_name',
        'campus_name'
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

        static::deleting(function ($event) {
            // Delete image when event is deleted
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
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
     * Get confirmed registrations.
     */
    public function confirmedRegistrations()
    {
        return $this->hasMany(EventRegistration::class)->where('status', 'confirmed');
    }

    /**
     * Get waitlists.
     */
    public function waitlists()
    {
        return $this->hasMany(Waitlist::class);
    }

    /**
     * Check if a user is registered for this event.
     */
    public function isRegisteredByUser($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return false;
        }
        
        return $this->registrations()
            ->where('user_id', $userId)
            ->whereIn('status', ['confirmed', 'pending'])
            ->exists();
    }

    /**
     * Check if a user is on the waitlist for this event.
     */
    public function isOnWaitlistByUser($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return false;
        }
        
        return $this->waitlists()
            ->where('user_id', $userId)
            ->whereNull('converted_at')
            ->exists();
    }

    /**
     * Get user's waitlist position.
     */
    public function getUserWaitlistPosition($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return null;
        }
        
        $waitlist = $this->waitlists()
            ->where('user_id', $userId)
            ->whereNull('converted_at')
            ->first();
            
        return $waitlist ? $waitlist->position : null;
    }

    /**
     * Add a user to the waitlist.
     */
    public function addToWaitlist($userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return null;
        }
        
        // Check if already on waitlist
        if ($this->isOnWaitlistByUser($userId)) {
            return null;
        }
        
        // Get next position
        $nextPosition = $this->waitlists()->whereNull('converted_at')->max('position') ?? 0;
        $nextPosition++;
        
        return $this->waitlists()->create([
            'user_id' => $userId,
            'position' => $nextPosition,
            'joined_at' => now(),
        ]);
    }

    /**
     * Fill seats from waitlist when spots become available.
     */
    public function fillFromWaitlist($numberOfSpots = 1)
    {
        $movedUsers = [];
        
        $waitlistEntries = $this->waitlists()
            ->with('user')
            ->whereNull('converted_at')
            ->orderBy('position')
            ->limit($numberOfSpots)
            ->get();
        
        foreach ($waitlistEntries as $waitlistEntry) {
            // Create registration
            $registration = EventRegistration::create([
                'event_id' => $this->id,
                'user_id' => $waitlistEntry->user_id,
                'guest_count' => 1,
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
            
            // Update registered attendees count
            $this->increment('registered_attendees', 1);
            
            // Mark waitlist as converted
            $waitlistEntry->update([
                'converted_at' => now(),
            ]);
            
            $movedUsers[] = $waitlistEntry->user;
        }
        
        return $movedUsers;
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
            return asset('images/default-event.jpg');
        }
        
        // Check if it's already a URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        // Check if file exists in storage
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }
        
        return asset('images/default-event.jpg');
    }

    /**
     * Get image path for storage.
     */
    public function getImagePathAttribute()
    {
        if (!$this->image) {
            return null;
        }
        
        return 'public/' . $this->image;
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

    /**
     * Delete the event image from storage.
     */
    public function deleteImage()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
            $this->image = null;
            $this->save();
        }
    }

    /**
     * Upload a new image for the event.
     */
    public function uploadImage($file)
    {
        // Delete old image if exists
        $this->deleteImage();
        
        // Generate unique filename
        $filename = 'event-' . $this->id . '-' . time() . '.' . $file->getClientOriginalExtension();
        
        // Store the file
        $path = $file->storeAs('events', $filename, 'public');
        
        // Update the event with new image path
        $this->image = $path;
        $this->save();
        
        return $path;
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeAttribute()
    {
        $status = $this->getStatusAttribute();
        
        $badges = [
            'upcoming' => ['class' => 'bg-primary', 'text' => 'Upcoming'],
            'ongoing' => ['class' => 'bg-success', 'text' => 'Ongoing'],
            'completed' => ['class' => 'bg-secondary', 'text' => 'Completed']
        ];
        
        return $badges[$status] ?? ['class' => 'bg-secondary', 'text' => 'Unknown'];
    }

    /**
     * Check if the event has an image.
     */
    public function hasImage()
    {
        return !empty($this->image);
    }
}