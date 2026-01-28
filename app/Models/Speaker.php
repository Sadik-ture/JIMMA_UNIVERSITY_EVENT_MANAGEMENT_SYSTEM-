<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Speaker extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'position',
        'organization',
        'email',
        'phone',
        'bio',
        'photo',
        'website',
        'twitter',
        'linkedin',
        'facebook',
        'is_featured',
        'is_active',
        'expertise',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'expertise' => 'array',
    ];

    // Relationship with events
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_speaker')
                    ->withPivot('session_title', 'session_time', 'session_duration', 'session_description', 'order', 'is_keynote')
                    ->withTimestamps()
                    ->orderBy('order');
    }

    // Accessor for full name with title
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $name = $this->name;
                if ($this->title) {
                    $name = $this->title . ' ' . $name;
                }
                return $name;
            }
        );
    }

    // Accessor for display name
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $display = $this->full_name;
                if ($this->position || $this->organization) {
                    $display .= ' - ' . ($this->position ?: $this->organization);
                }
                return $display;
            }
        );
    }
    

    // Scope for active speakers
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for featured speakers
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    // Scope for search
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('position', 'like', "%{$search}%")
              ->orWhere('organization', 'like', "%{$search}%")
              ->orWhere('bio', 'like', "%{$search}%");
        });
    }

    // Get social media links
    public function getSocialLinksAttribute()
    {
        $links = [];
        
        if ($this->twitter) {
            $links['twitter'] = 'https://twitter.com/' . ltrim($this->twitter, '@');
        }
        
        if ($this->linkedin) {
            $links['linkedin'] = $this->linkedin;
        }
        
        if ($this->facebook) {
            $links['facebook'] = $this->facebook;
        }
        
        if ($this->website) {
            $links['website'] = $this->website;
        }
        
        return $links;
    }

    // Get events count
    public function getEventsCountAttribute()
    {
        return $this->events()->count();
    }

    // Get upcoming events
    public function upcomingEvents()
    {
        return $this->events()->where('start_date', '>', now())->get();
    }
}