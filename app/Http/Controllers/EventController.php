<?php
// app/Http/Controllers/EventController.php - UPDATED VERSION

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Campus;
use App\Models\Building;
use App\Models\Venue;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query()->with(['campusRelation', 'buildingRelation', 'venueRelation', 'speakers']);
        
        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Filter by event type
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }
        
        // Filter by campus
        if ($request->filled('campus_id')) {
            $query->where('campus_id', $request->campus_id);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status == 'upcoming') {
                $query->upcoming();
            } elseif ($request->status == 'past') {
                $query->past();
            } elseif ($request->status == 'ongoing') {
                $query->ongoing();
            }
        }
        
        // Filter by featured
        if ($request->filled('featured') && $request->featured == '1') {
            $query->featured();
        }
        
        // Filter by speaker
        if ($request->filled('speaker_id')) {
            $query->whereHas('speakers', function ($q) use ($request) {
                $q->where('speakers.id', $request->speaker_id);
            });
        }
        
        // Default: show upcoming and ongoing events
        if (!$request->filled('status')) {
            $query->where('end_date', '>=', now()->subDays(1));
        }
        
        // Apply sorting
        $sort = $request->get('sort', 'start_date');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort, $order);
        
        $events = $query->paginate(20)->withQueryString();
        
        // Get statistics
        $totalCount = Event::count();
        $upcomingCount = Event::upcoming()->count();
        $ongoingCount = Event::ongoing()->count();
        $completedCount = Event::past()->count();
        $featuredCount = Event::featured()->count();
        
        // Get filter options
        $campuses = Campus::active()->get();
        $buildings = Building::active()->get();
        $venues = Venue::available()->get();
        $speakers = Speaker::active()->orderBy('name')->get();
        
        return view('admin.events.index', compact(
            'events', 
            'totalCount', 
            'upcomingCount', 
            'ongoingCount', 
            'completedCount',
            'featuredCount',
            'campuses',
            'buildings',
            'venues',
            'speakers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $campuses = Campus::active()->get();
        $buildings = Building::active()->get();
        $venues = Venue::available()->get();
        $speakers = Speaker::active()->orderBy('name')->get();
        
        $eventTypes = [
            'academic' => 'Academic',
            'cultural' => 'Cultural',
            'sports' => 'Sports',
            'conference' => 'Conference',
            'workshop' => 'Workshop',
            'seminar' => 'Seminar'
        ];
        
        return view('admin.events.create', compact('campuses', 'buildings', 'venues', 'speakers', 'eventTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:200',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'campus_id' => 'nullable|exists:campuses,id',
            'building_id' => 'nullable|exists:buildings,id',
            'venue_id' => 'nullable|exists:venues,id',
            'campus' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'event_type' => 'required|string|in:academic,cultural,sports,conference,workshop,seminar',
            'organizer' => 'required|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'max_attendees' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'requires_registration' => 'boolean',
            'registration_link' => 'nullable|url|required_if:requires_registration,1',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'additional_venue_info' => 'nullable|array',
            'speakers' => 'nullable|array',
            'speakers.*.speaker_id' => 'nullable|exists:speakers,id',
            'speakers.*.session_title' => 'nullable|string|max:255',
            'speakers.*.session_time' => 'nullable|date',
            'speakers.*.session_duration' => 'nullable|integer|min:1',
            'speakers.*.session_description' => 'nullable|string',
            'speakers.*.is_keynote' => 'nullable|boolean',
        ]);

        // Generate slug
        $slug = Str::slug($validated['title']);
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['title']) . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        // Process tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $validated['tags'] = array_slice($tags, 0, 10);
        }

        // Get names for string fields if IDs are provided
        if ($request->filled('campus_id') && empty($validated['campus'])) {
            $campus = Campus::find($request->campus_id);
            $validated['campus'] = $campus ? $campus->name : null;
        }
        
        if ($request->filled('building_id') && empty($validated['building'])) {
            $building = Building::find($request->building_id);
            $validated['building'] = $building ? $building->name : null;
        }
        
        if ($request->filled('venue_id') && empty($validated['venue'])) {
            $venue = Venue::find($request->venue_id);
            $validated['venue'] = $venue ? $venue->name : null;
        }

        // Create event first
        $event = Event::create($validated);

        // Handle image upload after event is created
        if ($request->hasFile('image')) {
            $event->uploadImage($request->file('image'));
        }

        // Handle speaker assignments
        if ($request->has('speakers') && is_array($request->speakers)) {
            $speakerData = array_filter($request->speakers, function ($speaker) {
                return !empty($speaker['speaker_id']);
            });
            
            if (!empty($speakerData)) {
                $event->syncSpeakers($speakerData);
            }
        }

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['campusRelation', 'buildingRelation', 'venueRelation', 'speakers']);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $event->load(['campusRelation', 'buildingRelation', 'venueRelation', 'speakers']);
        $campuses = Campus::active()->get();
        $buildings = Building::active()->where('campus_id', $event->campus_id)->get();
        $venues = Venue::available()->where('building_id', $event->building_id)->get();
        $speakers = Speaker::active()->orderBy('name')->get();
        
        $assignedSpeakerIds = $event->speakers->pluck('id')->toArray();
        
        $eventTypes = [
            'academic' => 'Academic',
            'cultural' => 'Cultural',
            'sports' => 'Sports',
            'conference' => 'Conference',
            'workshop' => 'Workshop',
            'seminar' => 'Seminar'
        ];
        
        return view('admin.events.edit', compact(
            'event', 
            'campuses', 
            'buildings', 
            'venues', 
            'speakers',
            'assignedSpeakerIds',
            'eventTypes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:200',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'campus_id' => 'nullable|exists:campuses,id',
            'building_id' => 'nullable|exists:buildings,id',
            'venue_id' => 'nullable|exists:venues,id',
            'campus' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'event_type' => 'required|string|in:academic,cultural,sports,conference,workshop,seminar',
            'organizer' => 'required|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'max_attendees' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'requires_registration' => 'boolean',
            'registration_link' => 'nullable|url|required_if:requires_registration,1',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'additional_venue_info' => 'nullable|array',
            'remove_image' => 'nullable|boolean',
            'speakers' => 'nullable|array',
            'speakers.*.speaker_id' => 'nullable|exists:speakers,id',
            'speakers.*.session_title' => 'nullable|string|max:255',
            'speakers.*.session_time' => 'nullable|date',
            'speakers.*.session_duration' => 'nullable|integer|min:1',
            'speakers.*.session_description' => 'nullable|string',
            'speakers.*.is_keynote' => 'nullable|boolean',
        ]);

        // Update slug if title changed
        if ($event->title !== $validated['title']) {
            $slug = Str::slug($validated['title']);
            $counter = 1;
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = Str::slug($validated['title']) . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        // Process tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $validated['tags'] = array_slice($tags, 0, 10);
        } else {
            $validated['tags'] = null;
        }

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            $event->deleteImage();
            $validated['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            $event->uploadImage($request->file('image'));
        }

        // Get names for string fields if IDs are provided
        if ($request->filled('campus_id') && empty($validated['campus'])) {
            $campus = Campus::find($request->campus_id);
            $validated['campus'] = $campus ? $campus->name : null;
        }
        
        if ($request->filled('building_id') && empty($validated['building'])) {
            $building = Building::find($request->building_id);
            $validated['building'] = $building ? $building->name : null;
        }
        
        if ($request->filled('venue_id') && empty($validated['venue'])) {
            $venue = Venue::find($request->venue_id);
            $validated['venue'] = $venue ? $venue->name : null;
        }

        $event->update($validated);

        // Handle speaker assignments
        if ($request->has('speakers') && is_array($request->speakers)) {
            $speakerData = array_filter($request->speakers, function ($speaker) {
                return !empty($speaker['speaker_id']);
            });
            
            if (!empty($speakerData)) {
                $event->syncSpeakers($speakerData);
            } else {
                $event->speakers()->detach();
            }
        } else {
            $event->speakers()->detach();
        }

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete image if exists
        $event->deleteImage();
        
        // Detach speakers
        $event->speakers()->detach();
        
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Event $event)
    {
        $event->toggleFeatured();
        
        return redirect()->back()
            ->with('success', 'Featured status updated successfully.');
    }

    /**
     * Toggle public status
     */
    public function togglePublic(Event $event)
    {
        $event->togglePublic();
        
        return redirect()->back()
            ->with('success', 'Visibility status updated successfully.');
    }

    /**
     * Get buildings for a campus (AJAX)
     */
    public function getBuildings($campusId)
    {
        $buildings = Building::where('campus_id', $campusId)
                            ->where('is_active', true)
                            ->get(['id', 'name', 'code']);
        
        return response()->json($buildings);
    }

    /**
     * Get venues for a building (AJAX)
     */
    public function getVenues($buildingId)
    {
        $venues = Venue::where('building_id', $buildingId)
                      ->where('is_available', true)
                      ->get(['id', 'name', 'type', 'capacity']);
        
        return response()->json($venues);
    }

    /**
     * Get venue details (AJAX)
     */
    public function getVenueDetails($venueId)
    {
        $venue = Venue::find($venueId);
        
        if (!$venue) {
            return response()->json(['error' => 'Venue not found'], 404);
        }
        
        return response()->json([
            'name' => $venue->name,
            'type' => $venue->type,
            'capacity' => $venue->capacity,
            'description' => $venue->description,
            'amenities' => $venue->amenities ?? []
        ]);
    }

    /**
     * Duplicate event
     */
    public function duplicate(Event $event)
    {
        $newEvent = $event->replicate();
        $newEvent->title = $event->title . ' (Copy)';
        $newEvent->slug = Str::slug($newEvent->title);
        $newEvent->is_featured = false;
        $newEvent->registered_attendees = 0;
        
        // Don't copy the image
        $newEvent->image = null;
        
        $newEvent->save();

        // Copy speakers
        $speakerData = [];
        foreach ($event->speakers as $speaker) {
            $speakerData[] = [
                'speaker_id' => $speaker->id,
                'session_title' => $speaker->pivot->session_title,
                'session_time' => $speaker->pivot->session_time,
                'session_duration' => $speaker->pivot->session_duration,
                'session_description' => $speaker->pivot->session_description,
                'order' => $speaker->pivot->order,
                'is_keynote' => $speaker->pivot->is_keynote,
                'is_moderator' => $speaker->pivot->is_moderator,
                'is_panelist' => $speaker->pivot->is_panelist,
            ];
        }
        
        if (!empty($speakerData)) {
            $newEvent->syncSpeakers($speakerData);
        }

        return redirect()->route('admin.events.edit', $newEvent)
            ->with('success', 'Event duplicated successfully. You can now edit the copy.');
    }

    /**
     * Export events
     */
    public function export(Request $request)
    {
        $events = Event::where('end_date', '>=', now())->with('speakers')->get();
        
        $csvData = "Title,Description,Start Date,End Date,Campus,Building,Venue,Type,Organizer,Speakers,Max Attendees,Status\n";
        
        foreach ($events as $event) {
            $speakerNames = $event->speakers->pluck('name')->implode('; ');
            
            $csvData .= '"' . str_replace('"', '""', $event->title) . '",';
            $csvData .= '"' . str_replace('"', '""', $event->short_description ?: $event->description) . '",';
            $csvData .= $event->start_date->format('Y-m-d H:i') . ',';
            $csvData .= $event->end_date->format('Y-m-d H:i') . ',';
            $csvData .= $event->campus_name . ',';
            $csvData .= $event->building_name . ',';
            $csvData .= $event->venue_name . ',';
            $csvData .= ucfirst($event->event_type) . ',';
            $csvData .= $event->organizer . ',';
            $csvData .= '"' . $speakerNames . '",';
            $csvData .= ($event->max_attendees ?: 'Unlimited') . ',';
            $csvData .= ucfirst($event->status) . "\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="events_' . date('Y-m-d') . '.csv"');
    }
}