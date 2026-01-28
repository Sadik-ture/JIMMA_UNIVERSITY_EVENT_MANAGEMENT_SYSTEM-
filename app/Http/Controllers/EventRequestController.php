<?php

namespace App\Http\Controllers;

use App\Models\EventRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventRequestController extends Controller
{
    /**
     * Display a listing of event requests
     */
    public function index(Request $request)
    {
        $query = EventRequest::query()->with('user', 'reviewer', 'event');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by user role (non-admin users see only their own requests)
        if (!auth()->user()->hasPermission('manage_events')) {
            $query->where('user_id', auth()->id());
        }
        
        // Filter by user
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }
        
        // Apply search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('organizer_name', 'like', "%{$request->search}%")
                  ->orWhere('organizer_email', 'like', "%{$request->search}%");
            });
        }
        
        // Filter by event type
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }
        
        // Count statistics
        $totalCount = EventRequest::count();
        $pendingCount = EventRequest::where('status', 'pending')->count();
        $approvedCount = EventRequest::where('status', 'approved')->count();
        $rejectedCount = EventRequest::where('status', 'rejected')->count();
        $cancelledCount = EventRequest::where('status', 'cancelled')->count();
        
        // Get paginated results
        $requests = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        
        return view('event-requests.index', compact(
            'requests',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'cancelledCount'
        ));
    }

    /**
     * Show the form for creating a new event request
     */
    public function create()
    {
        return view('event-requests.create');
    }

    /**
     * Store a newly created event request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'proposed_start_date' => 'required|date',
            'proposed_end_date' => 'required|date|after:proposed_start_date',
            'proposed_venue' => 'required|string|max:255',
            'proposed_campus' => 'nullable|string|max:255',
            'event_type' => 'required|string|in:academic,cultural,sports,conference,workshop,seminar',
            'organizer_name' => 'required|string|max:255',
            'organizer_email' => 'required|email',
            'organizer_phone' => 'nullable|string|max:20',
            'expected_attendees' => 'nullable|integer|min:1',
            'additional_requirements' => 'nullable|string',
        ]);

        // Create event request
        $eventRequest = EventRequest::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        // Send notification to admins (you can implement this later)
        // Notification::send(User::whereHasPermission('manage_events')->get(), new NewEventRequest($eventRequest));

        return redirect()->route('event-requests.show', $eventRequest)
            ->with('success', 'Event request submitted successfully. It will be reviewed by the administration.');
    }

    /**
     * Display the specified event request
     */
    public function show(EventRequest $eventRequest)
    {
        // Check if user has permission to view this request
        if (!auth()->user()->hasPermission('manage_events') && $eventRequest->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $eventRequest->load('user', 'reviewer', 'event');
        
        return view('event-requests.show', compact('eventRequest'));
    }

    /**
     * Show the form for editing the specified event request
     */
    public function edit(EventRequest $eventRequest)
    {
        // Only allow editing if pending and user owns the request
        if ($eventRequest->user_id !== auth()->id() || $eventRequest->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }
        
        return view('event-requests.edit', compact('eventRequest'));
    }

    /**
     * Update the specified event request
     */
    public function update(Request $request, EventRequest $eventRequest)
    {
        // Only allow updating if pending and user owns the request
        if ($eventRequest->user_id !== auth()->id() || $eventRequest->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'proposed_start_date' => 'required|date',
            'proposed_end_date' => 'required|date|after:proposed_start_date',
            'proposed_venue' => 'required|string|max:255',
            'proposed_campus' => 'nullable|string|max:255',
            'event_type' => 'required|string|in:academic,cultural,sports,conference,workshop,seminar',
            'organizer_name' => 'required|string|max:255',
            'organizer_email' => 'required|email',
            'organizer_phone' => 'nullable|string|max:20',
            'expected_attendees' => 'nullable|integer|min:1',
            'additional_requirements' => 'nullable|string',
        ]);

        $eventRequest->update($validated);

        return redirect()->route('event-requests.show', $eventRequest)
            ->with('success', 'Event request updated successfully.');
    }

    /**
     * Cancel the specified event request
     */
    public function cancel(EventRequest $eventRequest)
    {
        // Only allow cancelling if pending and user owns the request
        if ($eventRequest->user_id !== auth()->id() || $eventRequest->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }
        
        $eventRequest->update(['status' => 'cancelled']);

        return back()->with('success', 'Event request cancelled successfully.');
    }

    /**
     * Approve event request (admin only)
     */
    public function approve(Request $request, EventRequest $eventRequest)
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_events')) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($eventRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }
        
        $validated = $request->validate([
            'review_notes' => 'nullable|string',
        ]);

        // Create event from request
        $eventData = [
            'title' => $eventRequest->title,
            'description' => $eventRequest->description,
            'start_date' => $eventRequest->proposed_start_date,
            'end_date' => $eventRequest->proposed_end_date,
            'venue' => $eventRequest->proposed_venue,
            'campus' => $eventRequest->proposed_campus,
            'event_type' => $eventRequest->event_type,
            'organizer' => $eventRequest->organizer_name,
            'contact_email' => $eventRequest->organizer_email,
            'contact_phone' => $eventRequest->organizer_phone,
            'max_attendees' => $eventRequest->expected_attendees,
            'is_public' => true,
            'is_featured' => false,
            'requires_registration' => $eventRequest->expected_attendees > 0,
        ];

        // Generate slug
        $slug = Str::slug($eventRequest->title);
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($eventRequest->title) . '-' . $counter;
            $counter++;
        }
        $eventData['slug'] = $slug;

        // Create event
        $event = Event::create($eventData);

        // Update event request
        $eventRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'review_notes' => $validated['review_notes'],
            'reviewed_at' => now(),
            'event_id' => $event->id,
        ]);

        // Send notification to requester (implement later)
        // $eventRequest->user->notify(new EventRequestApproved($eventRequest, $event));

        return back()->with('success', 'Event request approved and event created successfully.');
    }

    /**
     * Reject event request (admin only)
     */
    public function reject(Request $request, EventRequest $eventRequest)
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage_events')) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($eventRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }
        
        $validated = $request->validate([
            'review_notes' => 'required|string',
        ]);

        $eventRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'review_notes' => $validated['review_notes'],
            'reviewed_at' => now(),
        ]);

        // Send notification to requester (implement later)
        // $eventRequest->user->notify(new EventRequestRejected($eventRequest));

        return back()->with('success', 'Event request rejected successfully.');
    }
}