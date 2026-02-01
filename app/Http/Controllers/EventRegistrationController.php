<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Waitlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventParticipantsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class EventRegistrationController extends Controller
{
    /**
     * Display upcoming events for registration
     */
    public function index(Request $request)
    {
        $query = Event::query()
            ->where('is_public', true)
            ->where('requires_registration', true)
            ->where('end_date', '>=', now())
            ->orderBy('start_date');
        
        // Apply filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }
        
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }
        
        if ($request->filled('campus')) {
            $query->where('campus', $request->campus);
        }
        
        $events = $query->paginate(12);
        
        // Get user's registered events
        $registeredEventIds = [];
        if (Auth::check()) {
            $registeredEventIds = EventRegistration::where('user_id', Auth::id())
                ->whereIn('status', ['confirmed', 'pending'])
                ->pluck('event_id')
                ->toArray();
        }
        
        return view('events.registration.index', compact('events', 'registeredEventIds'));
    }

    /**
     * Show event registration form
     */
    public function create(Event $event)
    {
        // Check if event requires registration
        if (!$event->requires_registration || !$event->is_public) {
            return redirect()->route('events.guest.show', $event)
                ->with('error', 'This event does not require registration or is not public.');
        }
        
        // Check if already registered
        if (Auth::check() && $event->isRegisteredByUser()) {
            return redirect()->route('my-events.index')
                ->with('info', 'You are already registered for this event.');
        }
        
        // Check if on waitlist
        if (Auth::check() && $event->isOnWaitlistByUser()) {
            return redirect()->route('my-events.index')
                ->with('info', 'You are on the waitlist for this event.');
        }
        
        // Check if event is full
        $isFull = $event->is_full;
        $availableSeats = $event->available_seats;
        
        return view('events.registration.create', compact('event', 'isFull', 'availableSeats'));
    }

    /**
     * Register for an event
     */
    public function store(Request $request, Event $event)
    {
        // Validation
        $validated = $request->validate([
            'guest_count' => 'required|integer|min:1|max:5',
            'additional_info' => 'nullable|string|max:1000',
            'agree_terms' => 'required|accepted',
        ]);
        
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to register for events.')
                ->with('redirect', url()->current());
        }
        
        // Check if event requires registration
        if (!$event->requires_registration || !$event->is_public) {
            return redirect()->back()
                ->with('error', 'This event does not require registration.');
        }
        
        // Check if already registered
        if ($event->isRegisteredByUser()) {
            return redirect()->route('my-events.index')
                ->with('info', 'You are already registered for this event.');
        }
        
        // Check if on waitlist
        if ($event->isOnWaitlistByUser()) {
            return redirect()->route('my-events.index')
                ->with('info', 'You are already on the waitlist for this event.');
        }
        
        // Check if event is full
        if ($event->is_full) {
            // Add to waitlist
            $waitlist = $event->addToWaitlist(Auth::id());
            
            if ($waitlist) {
                return redirect()->route('my-events.index')
                    ->with('success', 'Event is full. You have been added to the waitlist at position ' . $waitlist->position . '.');
            }
            
            return redirect()->back()
                ->with('error', 'Failed to add you to the waitlist.');
        }
        
        // Check if enough seats available
        if ($event->max_attendees && $validated['guest_count'] > $event->available_seats) {
            return redirect()->back()
                ->with('error', 'Only ' . $event->available_seats . ' seats available.');
        }
        
        // Create registration
        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'guest_count' => $validated['guest_count'],
            'additional_info' => $validated['additional_info'],
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
        
        // Update registered attendees count
        if ($event->max_attendees) {
            $event->increment('registered_attendees', $validated['guest_count']);
        }
        
        return redirect()->route('my-events.index')
            ->with('success', 'Successfully registered for ' . $event->title . '. Your registration number is: ' . $registration->registration_number);
    }

    /**
     * Cancel registration
     */
    public function cancel(Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['confirmed', 'pending'])
            ->first();
        
        if (!$registration) {
            return redirect()->back()
                ->with('error', 'You are not registered for this event.');
        }
        
        // Update registration status
        $registration->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => 'Cancelled by user',
        ]);
        
        // Update registered attendees count
        if ($event->max_attendees) {
            $event->decrement('registered_attendees', $registration->guest_count);
        }
        
        // Move someone from waitlist if available
        $movedFromWaitlist = $event->fillFromWaitlist($registration->guest_count);
        
        $message = 'Your registration has been cancelled.';
        if (count($movedFromWaitlist) > 0) {
            $message .= ' ' . count($movedFromWaitlist) . ' person(s) from waitlist have been notified.';
        }
        
        return redirect()->route('my-events.index')
            ->with('success', $message);
    }

    /**
     * "My Events" page - show user's registered events
     */
    public function myEvents(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $query = EventRegistration::with('event')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $registrations = $query->paginate(15);
        
        // Get waitlisted events
        $waitlists = Waitlist::with('event')
            ->where('user_id', Auth::id())
            ->whereNull('converted_at')
            ->orderBy('position')
            ->get();
        
        // Get upcoming events count
        $upcomingCount = EventRegistration::where('user_id', Auth::id())
            ->whereHas('event', function ($q) {
                $q->where('start_date', '>', now());
            })
            ->whereIn('status', ['confirmed', 'pending'])
            ->count();
        
        // Get attended events count
        $attendedCount = EventRegistration::where('user_id', Auth::id())
            ->where('attended', true)
            ->count();
        
        return view('events.my-events', compact('registrations', 'waitlists', 'upcomingCount', 'attendedCount'));
    }

    /**
     * Show registration details
     */
    public function show(EventRegistration $registration)
    {
        // Authorization check
        if (Auth::id() !== $registration->user_id && !Auth::user()->hasPermission('manage_events')) {
            abort(403, 'Unauthorized action.');
        }
        
        $registration->load(['event', 'user']);
        
        return view('events.registration.show', compact('registration'));
    }

    /**
     * Organizer: List participants for an event
     */
    public function participants(Event $event)
    {
        // Authorization check - only organizers and admins
        if (!Auth::user()->hasPermission('manage_events')) {
            abort(403, 'Unauthorized action.');
        }
        
        $query = EventRegistration::with('user')
            ->where('event_id', $event->id)
            ->orderBy('created_at', 'desc');
        
        // Filter by status
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }
        
        $participants = $query->paginate(20);
        
        // Statistics
        $confirmedCount = $event->confirmedRegistrations()->count();
        $pendingCount = EventRegistration::where('event_id', $event->id)
            ->where('status', 'pending')
            ->count();
        $cancelledCount = EventRegistration::where('event_id', $event->id)
            ->where('status', 'cancelled')
            ->count();
        $attendedCount = EventRegistration::where('event_id', $event->id)
            ->where('attended', true)
            ->count();
        
        return view('events.participants.index', compact(
            'event', 'participants', 'confirmedCount',
            'pendingCount', 'cancelledCount', 'attendedCount'
        ));
    }

    /**
     * Organizer: Export participants to Excel
     */
    public function exportExcel(Event $event)
    {
        if (!Auth::user()->hasPermission('manage_events')) {
            abort(403, 'Unauthorized action.');
        }
        
        $filename = 'participants-' . Str::slug($event->title) . '-' . date('Y-m-d') . '.xlsx';
        
        return Excel::download(new EventParticipantsExport($event->id), $filename);
    }

    /**
     * Organizer: Export participants to PDF
     */
    public function exportPdf(Event $event)
    {
        if (!Auth::user()->hasPermission('manage_events')) {
            abort(403, 'Unauthorized action.');
        }
        
        $participants = EventRegistration::with('user')
            ->where('event_id', $event->id)
            ->where('status', 'confirmed')
            ->orderBy('created_at')
            ->get();
        
        $pdf = Pdf::loadView('exports.participants-pdf', compact('event', 'participants'));
        
        return $pdf->download('participants-' . Str::slug($event->title) . '-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Organizer: Check-in participant
     */
    public function checkIn(EventRegistration $registration)
    {
        if (!Auth::user()->hasPermission('manage_events')) {
            abort(403, 'Unauthorized action.');
        }
        
        $registration->update([
            'attended' => true,
            'check_in_time' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Participant checked in successfully.');
    }

    /**
     * Organizer: Update participant status
     */
    public function updateStatus(EventRegistration $registration, Request $request)
    {
        if (!Auth::user()->hasPermission('manage_events')) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'status' => 'required|in:confirmed,pending,cancelled',
            'notes' => 'nullable|string',
        ]);
        
        $oldStatus = $registration->status;
        $registration->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $registration->notes,
        ]);
        
        // If status changed from confirmed to cancelled, free up seats
        if ($oldStatus === 'confirmed' && $validated['status'] === 'cancelled') {
            if ($registration->event->max_attendees) {
                $registration->event->decrement('registered_attendees', $registration->guest_count);
                $registration->event->fillFromWaitlist($registration->guest_count);
            }
        }
        
        return redirect()->back()
            ->with('success', 'Participant status updated successfully.');
    }
}