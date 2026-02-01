<?php
// app/Http/Controllers/EventRequestController.php (Fixed Version)

namespace App\Http\Controllers;

use App\Models\EventRequest;
use App\Models\Event;
use App\Models\User;
use App\Models\Campus;
use App\Models\Building;
use App\Models\Venue;
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
        $query = EventRequest::with(['user', 'reviewer', 'event']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by user (if not admin)
        if (!Auth::user()->hasPermission('manage_event_requests')) {
            $query->where('user_id', Auth::id());
        }
        
        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%")
                  ->orWhere('organizer_name', 'like', "%{$request->search}%");
            });
        }
        
        $eventRequests = $query->latest()->paginate(20);
        
        // Statistics
        $totalCount = EventRequest::count();
        $pendingCount = EventRequest::pending()->count();
        $approvedCount = EventRequest::approved()->count();
        $rejectedCount = EventRequest::rejected()->count();
        $cancelledCount = EventRequest::where('status', 'cancelled')->count();
        $myRequestsCount = EventRequest::where('user_id', Auth::id())->count();
        
        return view('event-requests.index', compact(
            'eventRequests', 
            'totalCount',
            'pendingCount', 
            'approvedCount', 
            'rejectedCount',
            'cancelledCount',
            'myRequestsCount'
        ));
    }

    /**
     * Show the form for creating a new event request
     */
    public function create()
    {
        // Get all active campuses
        $campuses = Campus::active()->get();
        
        // Get all available venues
        $venues = Venue::with(['building.campus'])
            ->where('is_available', true)
            ->orderBy('name')
            ->get();
        
        return view('event-requests.create', compact('campuses', 'venues'));
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
            'venue_id' => 'nullable|exists:venues,id',
            'alternative_venue' => 'nullable|string|max:255',
            'campus_id' => 'nullable|exists:campuses,id',
            'building_id' => 'nullable|exists:buildings,id',
            'event_type' => 'required|string|in:academic,cultural,sports,conference,workshop,seminar',
            'organizer_name' => 'required|string|max:255',
            'organizer_email' => 'required|email',
            'organizer_phone' => 'nullable|string|max:20',
            'expected_attendees' => 'nullable|integer|min:1',
            'additional_requirements' => 'nullable|string',
        ]);

        // Determine the venue name
        $venueName = '';
        if ($validated['venue_id']) {
            $venue = Venue::with('building.campus')->find($validated['venue_id']);
            if ($venue) {
                $venueName = $venue->name . ' - ' . ($venue->building->name ?? 'N/A');
            }
        } elseif ($validated['alternative_venue']) {
            $venueName = $validated['alternative_venue'];
        }

        // Get campus name
        $campusName = '';
        if ($validated['campus_id']) {
            $campus = Campus::find($validated['campus_id']);
            $campusName = $campus->name ?? '';
        }

        // Create event request
        $eventRequest = EventRequest::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'proposed_start_date' => $validated['proposed_start_date'],
            'proposed_end_date' => $validated['proposed_end_date'],
            'proposed_venue' => $venueName,
            'proposed_campus' => $campusName,
            'venue_id' => $validated['venue_id'],
            'campus_id' => $validated['campus_id'],
            'building_id' => $validated['building_id'],
            'event_type' => $validated['event_type'],
            'organizer_name' => $validated['organizer_name'],
            'organizer_email' => $validated['organizer_email'],
            'organizer_phone' => $validated['organizer_phone'],
            'expected_attendees' => $validated['expected_attendees'],
            'additional_requirements' => $validated['additional_requirements'],
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('event-requests.show', $eventRequest)
            ->with('success', 'Event request submitted successfully. It will be reviewed by the administration.');
    }

    /**
     * Display the specified event request
     */
    public function show(EventRequest $eventRequest)
    {
        // Authorization check - allow if user is owner or has permission
        if (Auth::id() !== $eventRequest->user_id && !Auth::user()->hasPermission('manage_event_requests')) {
            abort(403, 'You are not authorized to view this event request.');
        }
        
        $eventRequest->load(['user', 'reviewer', 'event', 'venueRelation', 'campusRelation', 'buildingRelation']);
        
        return view('event-requests.show', compact('eventRequest'));
    }

    /**
     * Show the form for editing the specified event request
     */
    public function edit(EventRequest $eventRequest)
    {
        // Only allow editing if pending
        if ($eventRequest->status !== 'pending') {
            return redirect()->route('event-requests.show', $eventRequest)
                ->with('error', 'Cannot edit event request that is already reviewed.');
        }
        
        // Authorization check - only owner can edit
        if (Auth::id() !== $eventRequest->user_id) {
            abort(403, 'You are not authorized to edit this event request.');
        }
        
        $campuses = Campus::active()->get();
        $venues = Venue::with(['building.campus'])
            ->where('is_available', true)
            ->orderBy('name')
            ->get();
        
        return view('event-requests.edit', compact('eventRequest', 'campuses', 'venues'));
    }

    /**
     * Update the specified event request
     */
    public function update(Request $request, EventRequest $eventRequest)
    {
        // Only allow updating if pending
        if ($eventRequest->status !== 'pending') {
            return redirect()->route('event-requests.show', $eventRequest)
                ->with('error', 'Cannot update event request that is already reviewed.');
        }
        
        // Authorization check - only owner can update
        if (Auth::id() !== $eventRequest->user_id) {
            abort(403, 'You are not authorized to update this event request.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'proposed_start_date' => 'required|date',
            'proposed_end_date' => 'required|date|after:proposed_start_date',
            'venue_id' => 'nullable|exists:venues,id',
            'alternative_venue' => 'nullable|string|max:255',
            'campus_id' => 'nullable|exists:campuses,id',
            'building_id' => 'nullable|exists:buildings,id',
            'event_type' => 'required|string|in:academic,cultural,sports,conference,workshop,seminar',
            'organizer_name' => 'required|string|max:255',
            'organizer_email' => 'required|email',
            'organizer_phone' => 'nullable|string|max:20',
            'expected_attendees' => 'nullable|integer|min:1',
            'additional_requirements' => 'nullable|string',
        ]);

        // Determine the venue name
        $venueName = '';
        if ($validated['venue_id']) {
            $venue = Venue::with('building.campus')->find($validated['venue_id']);
            if ($venue) {
                $venueName = $venue->name . ' - ' . ($venue->building->name ?? 'N/A');
            }
        } elseif ($validated['alternative_venue']) {
            $venueName = $validated['alternative_venue'];
        }

        // Get campus name
        $campusName = '';
        if ($validated['campus_id']) {
            $campus = Campus::find($validated['campus_id']);
            $campusName = $campus->name ?? '';
        }

        // Update event request
        $eventRequest->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'proposed_start_date' => $validated['proposed_start_date'],
            'proposed_end_date' => $validated['proposed_end_date'],
            'proposed_venue' => $venueName,
            'proposed_campus' => $campusName,
            'venue_id' => $validated['venue_id'],
            'campus_id' => $validated['campus_id'],
            'building_id' => $validated['building_id'],
            'event_type' => $validated['event_type'],
            'organizer_name' => $validated['organizer_name'],
            'organizer_email' => $validated['organizer_email'],
            'organizer_phone' => $validated['organizer_phone'],
            'expected_attendees' => $validated['expected_attendees'],
            'additional_requirements' => $validated['additional_requirements'],
        ]);

        return redirect()->route('event-requests.show', $eventRequest)
            ->with('success', 'Event request updated successfully.');
    }

    /**
     * Remove the specified event request
     */
    public function destroy(EventRequest $eventRequest)
    {
        // Only allow deleting if pending
        if ($eventRequest->status !== 'pending') {
            return redirect()->route('event-requests.show', $eventRequest)
                ->with('error', 'Cannot delete event request that is already reviewed.');
        }
        
        // Authorization check - only owner or admin can delete
        if (Auth::id() !== $eventRequest->user_id && !Auth::user()->hasPermission('delete_event_request')) {
            abort(403, 'You are not authorized to delete this event request.');
        }
        
        $eventRequest->delete();
        
        return redirect()->route('event-requests.index')
            ->with('success', 'Event request deleted successfully.');
    }

    /**
     * Cancel an event request
     */
    public function cancel(Request $request, EventRequest $eventRequest)
    {
        // Authorization check - only owner can cancel
        if (Auth::id() !== $eventRequest->user_id) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to cancel this request.'
                ], 403);
            }
            abort(403, 'You are not authorized to cancel this request.');
        }
        
        $eventRequest->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Event request cancelled successfully!',
                'redirect' => route('event-requests.index')
            ]);
        }
        
        return redirect()->route('event-requests.show', $eventRequest)
            ->with('success', 'Event request cancelled successfully.');
    }

    /**
     * Approve an event request - FIXED AUTHORIZATION
     */
    public function approve(Request $request, EventRequest $eventRequest)
    {
        // Check if user has permission to approve event requests
        if (!Auth::user()->hasPermission('approve_event_requests')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to approve event requests.'
                ], 403);
            }
            abort(403, 'You are not authorized to approve event requests.');
        }
        
        $validated = $request->validate([
            'review_notes' => 'nullable|string',
            'create_event' => 'boolean',
        ]);
        
        // Create event if requested
        $event = null;
        if ($request->has('create_event') && $request->boolean('create_event')) {
            $event = $this->createEventFromRequest($eventRequest);
        }
        
        $eventRequest->update([
            'status' => 'approved',
            'review_notes' => $validated['review_notes'] ?? null,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'event_id' => $event ? $event->id : null,
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Event request approved successfully!',
                'redirect' => route('event-requests.index')
            ]);
        }
        
        return redirect()->route('event-requests.show', $eventRequest)
            ->with('success', 'Event request approved successfully.');
    }

    /**
     * Reject an event request - FIXED AUTHORIZATION
     */
    public function reject(Request $request, EventRequest $eventRequest)
    {
        // Check if user has permission to reject event requests
        if (!Auth::user()->hasPermission('reject_event_requests')) {
            // Fallback: if reject_event_requests doesn't exist, check for approve_event_requests
            if (!Auth::user()->hasPermission('approve_event_requests')) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to reject event requests.'
                    ], 403);
                }
                abort(403, 'You are not authorized to reject event requests.');
            }
        }
        
        $validated = $request->validate([
            'review_notes' => 'required|string',
        ]);
        
        $eventRequest->update([
            'status' => 'rejected',
            'review_notes' => $validated['review_notes'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Event request rejected successfully!',
                'redirect' => route('event-requests.index')
            ]);
        }
        
        return redirect()->route('event-requests.show', $eventRequest)
            ->with('success', 'Event request rejected successfully.');
    }

    /**
     * Create an event from an approved request
     */
    private function createEventFromRequest(EventRequest $eventRequest)
    {
        $slug = Str::slug($eventRequest->title);
        $counter = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($eventRequest->title) . '-' . $counter;
            $counter++;
        }
        
        return Event::create([
            'title' => $eventRequest->title,
            'slug' => $slug,
            'description' => $eventRequest->description,
            'short_description' => Str::limit($eventRequest->description, 200),
            'start_date' => $eventRequest->proposed_start_date,
            'end_date' => $eventRequest->proposed_end_date,
            'campus_id' => $eventRequest->campus_id,
            'building_id' => $eventRequest->building_id,
            'venue_id' => $eventRequest->venue_id,
            'campus' => $eventRequest->proposed_campus,
            'venue' => $eventRequest->proposed_venue,
            'event_type' => $eventRequest->event_type,
            'organizer' => $eventRequest->organizer_name,
            'contact_email' => $eventRequest->organizer_email,
            'contact_phone' => $eventRequest->organizer_phone,
            'max_attendees' => $eventRequest->expected_attendees,
            'registered_attendees' => 0,
            'is_featured' => false,
            'is_public' => true,
            'requires_registration' => true,
            'status' => 'published',
        ]);
    }

    /**
     * Quick approve without modal (for AJAX)
     */
    public function quickApprove(Request $request, EventRequest $eventRequest)
    {
        // Check if user has permission to approve event requests
        if (!Auth::user()->hasPermission('approve_event_requests')) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to approve event requests.'
            ], 403);
        }
        
        $eventRequest->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Event request approved successfully!'
        ]);
    }

    /**
     * Quick reject without modal (for AJAX)
     */
    public function quickReject(Request $request, EventRequest $eventRequest)
    {
        // Check if user has permission to reject event requests
        if (!Auth::user()->hasPermission('reject_event_requests')) {
            // Fallback: if reject_event_requests doesn't exist, check for approve_event_requests
            if (!Auth::user()->hasPermission('approve_event_requests')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to reject event requests.'
                ], 403);
            }
        }
        
        $eventRequest->update([
            'status' => 'rejected',
            'review_notes' => 'Rejected via quick action',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Event request rejected successfully!'
        ]);
    }

    /**
     * Quick cancel without modal (for AJAX)
     */
    public function quickCancel(Request $request, EventRequest $eventRequest)
    {
        // Authorization check - only owner can cancel
        if (Auth::id() !== $eventRequest->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to cancel this request.'
            ], 403);
        }
        
        $eventRequest->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Event request cancelled successfully!'
        ]);
    }
}