<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

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
        
        // Check if Speaker model exists and has is_active column
        $speakerCount = 0;
        if (class_exists('App\Models\Speaker')) {
            // Check if column exists before querying
            $speakerModel = new Speaker();
            if (in_array('is_active', $speakerModel->getFillable())) {
                $speakerCount = Speaker::where('is_active', true)->count();
            } else {
                $speakerCount = Speaker::count();
            }
        }
        
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
        
        // Safely load speakers if relationship exists
        if (method_exists($event, 'speakers')) {
            $event->load('speakers');
        }
        
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
     * Display guest event dashboard (Homepage).
     * This is the method that should be called for the homepage.
     */
    public function dashboard(Request $request)
    {
        // Get upcoming events
        $events = Event::where('is_public', true)
            ->where('end_date', '>=', now())
            ->orderBy('start_date')
            ->paginate(12);
        
        // Get featured events
        $featuredEvents = Event::where('is_public', true)
            ->where('end_date', '>=', now())
            ->where('is_featured', true)
            ->orderBy('start_date')
            ->limit(6)
            ->get();
        
        // If no featured events, show some upcoming events as featured
        if ($featuredEvents->isEmpty()) {
            $featuredEvents = Event::where('is_public', true)
                ->where('end_date', '>=', now())
                ->orderBy('start_date')
                ->limit(6)
                ->get();
        }
        
        // Get upcoming event count
        $upcomingCount = Event::where('is_public', true)
            ->where('start_date', '>', now())
            ->count();
        
        // Get active speakers
        $speakerCount = 0;
        if (class_exists('App\Models\Speaker')) {
            $speakerModel = new Speaker();
            if (in_array('is_active', $speakerModel->getFillable())) {
                $speakerCount = Speaker::where('is_active', true)->count();
            } else {
                $speakerCount = Speaker::count();
            }
        }
        
        // Get search query if any
        $searchQuery = $request->get('search');
        
        return view('events.guest.dashboard', compact(
            'events',
            'featuredEvents',
            'upcomingCount',
            'speakerCount',
            'searchQuery'
        ));
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

    /**
     * Export event to ICS calendar format.
     */
    public function exportICS(Event $event)
    {
        if (!$event->is_public) {
            abort(404);
        }
        
        $icsContent = $this->generateICS($event);
        
        return Response::make($icsContent, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . Str::slug($event->title) . '.ics"'
        ]);
    }

    /**
     * Generate ICS content for an event.
     */
    private function generateICS(Event $event)
    {
        $startDate = $event->start_date->format('Ymd\THis');
        $endDate = $event->end_date->format('Ymd\THis');
        
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//Jimma University//Event Management System//EN\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:" . uniqid() . "@ju.edu.et\r\n";
        $ics .= "DTSTAMP:" . now()->format('Ymd\THis') . "\r\n";
        $ics .= "DTSTART:" . $startDate . "\r\n";
        $ics .= "DTEND:" . $endDate . "\r\n";
        $ics .= "SUMMARY:" . $this->escapeICS($event->title) . "\r\n";
        $ics .= "DESCRIPTION:" . $this->escapeICS(strip_tags($event->description)) . "\r\n";
        $ics .= "LOCATION:" . $this->escapeICS($event->venue_name . ", " . $event->campus_name) . "\r\n";
        $ics .= "ORGANIZER;CN=" . $this->escapeICS($event->organizer) . ":MAILTO:" . ($event->contact_email ?? 'events@ju.edu.et') . "\r\n";
        $ics .= "URL:" . route('events.guest.show', $event) . "\r\n";
        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";
        
        return $ics;
    }

    /**
     * Escape special characters for ICS format.
     */
    private function escapeICS($string)
    {
        $string = str_replace(["\r\n", "\r", "\n"], "\\n", $string);
        $string = str_replace(',', '\,', $string);
        $string = str_replace(';', '\;', $string);
        return $string;
    }

    /**
     * Home method (alias for dashboard).
     */
    public function home()
    {
        return $this->dashboard(new Request());
    }
}