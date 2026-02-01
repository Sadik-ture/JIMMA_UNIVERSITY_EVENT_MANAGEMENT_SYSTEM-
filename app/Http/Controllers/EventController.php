<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Campus;
use App\Models\Building;
use App\Models\Venue;
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
        $query = Event::query()->with(['campusRelation', 'buildingRelation', 'venueRelation']);
        
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
        
        // Filter by building
        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }
        
        // Filter by venue
        if ($request->filled('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }
        
        // Filter by featured
        if ($request->filled('featured') && $request->featured == '1') {
            $query->featured();
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
        
        // Filter by visibility
        if ($request->filled('visibility')) {
            if ($request->visibility == 'public') {
                $query->where('is_public', true);
            } elseif ($request->visibility == 'private') {
                $query->where('is_public', false);
            }
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
        
        return view('admin.events.index', compact(
            'events', 
            'totalCount', 
            'upcomingCount', 
            'ongoingCount', 
            'completedCount',
            'featuredCount',
            'campuses',
            'buildings',
            'venues'
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
        
        $eventTypes = [
            'academic' => 'Academic',
            'cultural' => 'Cultural',
            'sports' => 'Sports',
            'conference' => 'Conference',
            'workshop' => 'Workshop',
            'seminar' => 'Seminar'
        ];
        
        return view('admin.events.create', compact('campuses', 'buildings', 'venues', 'eventTypes'));
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

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
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

        // Create event
        $event = Event::create($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['campusRelation', 'buildingRelation', 'venueRelation']);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $event->load(['campusRelation', 'buildingRelation', 'venueRelation']);
        $campuses = Campus::active()->get();
        $buildings = Building::active()->where('campus_id', $event->campus_id)->get();
        $venues = Venue::available()->where('building_id', $event->building_id)->get();
        
        $eventTypes = [
            'academic' => 'Academic',
            'cultural' => 'Cultural',
            'sports' => 'Sports',
            'conference' => 'Conference',
            'workshop' => 'Workshop',
            'seminar' => 'Seminar'
        ];
        
        return view('admin.events.edit', compact('event', 'campuses', 'buildings', 'venues', 'eventTypes'));
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

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
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

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
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
            'description' => $venue->description
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
        $newEvent->created_at = now();
        $newEvent->updated_at = now();
        $newEvent->save();

        return redirect()->route('admin.events.edit', $newEvent)
            ->with('success', 'Event duplicated successfully. You can now edit the copy.');
    }

    /**
     * Export events
     */
    public function export(Request $request)
    {
        $events = Event::where('end_date', '>=', now())->get();
        
        $csvData = "Title,Description,Start Date,End Date,Campus,Building,Venue,Type,Organizer,Max Attendees,Status\n";
        
        foreach ($events as $event) {
            $csvData .= '"' . str_replace('"', '""', $event->title) . '",';
            $csvData .= '"' . str_replace('"', '""', $event->short_description) . '",';
            $csvData .= $event->start_date->format('Y-m-d H:i') . ',';
            $csvData .= $event->end_date->format('Y-m-d H:i') . ',';
            $csvData .= $event->campus_name . ',';
            $csvData .= $event->building_name . ',';
            $csvData .= $event->venue_name . ',';
            $csvData .= ucfirst($event->event_type) . ',';
            $csvData .= $event->organizer . ',';
            $csvData .= ($event->max_attendees ?: 'Unlimited') . ',';
            $csvData .= ucfirst($event->status) . "\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="events_' . date('Y-m-d') . '.csv"');
    }
}