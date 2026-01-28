<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;

class GuestEventController extends Controller
{
    /**
     * Display a listing of events for guests.
     */
    public function index(Request $request)
    {
        $query = Event::where('is_public', true);
        
        // Apply search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('venue', 'like', "%{$request->search}%")
                  ->orWhere('organizer', 'like', "%{$request->search}%");
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
        
        // Filter by time
        if ($request->filled('time')) {
            if ($request->time == 'upcoming') {
                $query->where('start_date', '>', now());
            } elseif ($request->time == 'past') {
                $query->where('end_date', '<', now());
            } elseif ($request->time == 'ongoing') {
                $query->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
            }
        } else {
            // Default: show upcoming and ongoing events
            $query->where('end_date', '>=', now()->subDays(1));
        }
        
        // Apply sorting
        $sort = $request->get('sort', 'start_date');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort, $order);
        
        $events = $query->paginate(12)->withQueryString();
        
        // Get statistics
        $upcomingCount = Event::where('is_public', true)
                             ->where('start_date', '>', now())
                             ->count();
        $speakerCount = Speaker::where('is_active', true)->count();
        
        return view('events.guest.dashboard', compact('events', 'upcomingCount', 'speakerCount'));
    }

    /**
     * Display the specified event for guests.
     */
    public function show(Event $event)
    {
        // Check if event is public
        if (!$event->is_public) {
            abort(404);
        }
        
        // Load related data
        $event->load('speakers');
        
        // Get similar events
        $similarEvents = Event::where('is_public', true)
                             ->where('event_type', $event->event_type)
                             ->where('id', '!=', $event->id)
                             ->where('start_date', '>', now())
                             ->limit(3)
                             ->get();
        
        return view('events.guest.show', compact('event', 'similarEvents'));
    }

    /**
     * Display guest event dashboard.
     */
    public function dashboard(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Share event page.
     */
    public function share(Event $event)
    {
        if (!$event->is_public) {
            abort(404);
        }
        
        return view('events.guest.share', compact('event'));
    }

 
    // Add this method to your GuestEventController.php
public function home()
{
    return $this->dashboard();
}

}