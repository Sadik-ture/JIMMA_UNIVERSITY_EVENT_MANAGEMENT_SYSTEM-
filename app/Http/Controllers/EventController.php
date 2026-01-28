<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();
        
        // Apply search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('organizer', 'like', "%{$request->search}%")
                  ->orWhere('venue', 'like', "%{$request->search}%");
            });
        }
        
        // Filter by event type
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }
        
        // Filter by campus
        if ($request->filled('campus')) {
            $query->where('campus', $request->campus);
        }
        
        // Filter by featured
        if ($request->filled('featured') && $request->featured == '1') {
            $query->where('is_featured', true);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status == 'upcoming') {
                $query->where('start_date', '>', now());
            } elseif ($request->status == 'past') {
                $query->where('end_date', '<', now());
            } elseif ($request->status == 'ongoing') {
                $query->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
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
        $upcomingCount = Event::where('start_date', '>', now())->count();
        $ongoingCount = Event::where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->count();
        $completedCount = Event::where('end_date', '<', now())->count();
        
        return view('admin.events.index', compact('events', 'totalCount', 'upcomingCount', 'ongoingCount', 'completedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'venue' => 'required|string|max:255',
            'campus' => 'nullable|string|max:255',
            'event_type' => 'required|string|in:academic,cultural,sports,conference,workshop,seminar',
            'organizer' => 'required|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'max_attendees' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'requires_registration' => 'boolean',
            'registration_link' => 'nullable|url',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate slug
        $slug = Str::slug($validated['title']);
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($validated['title']) . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        // Create event
        $event = Event::create($validated);

        return redirect()->route('admin.events.show', $event)
    ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'venue' => 'required|string|max:255',
            'campus' => 'nullable|string|max:255',
            'event_type' => 'required|string|in:academic,cultural,sports,conference,workshop,seminar',
            'organizer' => 'required|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'max_attendees' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'is_public' => 'boolean',
            'requires_registration' => 'boolean',
            'registration_link' => 'nullable|url',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image) {
                \Storage::disk('public')->delete($event->image);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $validated['image'] = $imagePath;
        }

        $event->update($validated);

        // return redirect()->route('events.show', $event)
        //     ->with('success', 'Event updated successfully.');
            return redirect()->route('admin.events.show', $event)
    ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete image if exists
        if ($event->image) {
            \Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();

        return redirect()->route('admin.events.index', $event)
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Event $event)
    {
        $event->update(['is_featured' => !$event->is_featured]);
        
        return redirect()->back()
            ->with('success', 'Featured status updated successfully.');
    }
}