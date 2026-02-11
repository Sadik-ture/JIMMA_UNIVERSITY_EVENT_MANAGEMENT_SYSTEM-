@extends('layouts.app')

@section('title', 'My Events')
@section('page-title', 'My Events')
@section('page-subtitle', 'Manage your event registrations and waitlists')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number">{{ $upcomingCount }}</div>
                <div class="stat-label">Upcoming Events</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">{{ $attendedCount }}</div>
                <div class="stat-label">Events Attended</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $waitlists->count() }}</div>
                <div class="stat-label">Waitlist Positions</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);">
                <div class="stat-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="stat-number">{{ $registrations->total() }}</div>
                <div class="stat-label">Total Registrations</div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="ju-card mb-4">
        <div class="ju-card-body p-0">
            <ul class="nav nav-tabs" id="myEventsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab">
                        <i class="fas fa-calendar-alt me-1"></i> Upcoming Events
                        @if($registrations->where('event.start_date', '>', now())->count() > 0)
                        <span class="badge bg-primary ms-1">{{ $registrations->where('event.start_date', '>', now())->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="waitlist-tab" data-bs-toggle="tab" data-bs-target="#waitlist" type="button" role="tab">
                        <i class="fas fa-clock me-1"></i> Waitlist
                        @if($waitlists->count() > 0)
                        <span class="badge bg-warning ms-1">{{ $waitlists->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button" role="tab">
                        <i class="fas fa-history me-1"></i> Past Events
                        @if($registrations->where('event.start_date', '<', now())->count() > 0)
                        <span class="badge bg-secondary ms-1">{{ $registrations->where('event.start_date', '<', now())->count() }}</span>
                        @endif
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="myEventsTabContent">
        <!-- Upcoming Events Tab -->
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
            @if($registrations->where('event.start_date', '>', now())->count() > 0)
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title m-0">Your Upcoming Events</h5>
                </div>
                <div class="ju-card-body">
                    <div class="table-responsive">
                        <table class="table table-ju">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date & Time</th>
                                    <th>Venue</th>
                                    <th>Registration No.</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                @if($registration->event->start_date > now())
                                <tr>
                                    <td>
                                        <strong>{{ $registration->event->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $registration->event->organizer }}</small>
                                    </td>
                                    <td>
                                        {{ $registration->event->start_date->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">{{ $registration->event->start_date->format('h:i A') }}</small>
                                    </td>
                                    <td>{{ $registration->event->venue }}, {{ $registration->event->campus }}</td>
                                    <td>
                                        <code>{{ $registration->registration_number }}</code>
                                        <br>
                                        <small class="text-muted">{{ $registration->guest_count }} guest(s)</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $registration->status_color }}">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- <a href="{{ route('events.guest.show', $registration->event) }}" 
                                               class="btn btn-outline-primary" title="View Event">
                                                <i class="fas fa-eye"></i>
                                            </a> -->
                                            <a href="{{ route('event-registration.show', $registration) }}" 
                                               class="btn btn-outline-info" title="View Registration">
                                                <i class="fas fa-ticket-alt"></i>
                                            </a>
                                            @if($registration->isConfirmed())
                                            <form action="{{ route('event-registration.cancel', $registration->event) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger" 
                                                        onclick="return confirm('Are you sure you want to cancel this registration?')"
                                                        title="Cancel Registration">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($registrations->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $registrations->withQueryString()->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="ju-card">
                <div class="ju-card-body text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No upcoming events</h4>
                    <p class="text-muted">You haven't registered for any upcoming events.</p>
                    <a href="{{ route('event-registration.index') }}" class="btn btn-ju">
                        <i class="fas fa-search me-1"></i> Browse Events
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Waitlist Tab -->
        <div class="tab-pane fade" id="waitlist" role="tabpanel">
            @if($waitlists->count() > 0)
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title m-0">Your Waitlist Positions</h5>
                </div>
                <div class="ju-card-body">
                    <div class="table-responsive">
                        <table class="table table-ju">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Event</th>
                                    <th>Date & Time</th>
                                    <th>Position</th>
                                    <th>Joined On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($waitlists as $waitlist)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $waitlist->event->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $waitlist->event->organizer }}</small>
                                    </td>
                                    <td>
                                        {{ $waitlist->event->start_date->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">{{ $waitlist->event->start_date->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="waitlist-position d-inline-flex">
                                            {{ $waitlist->position }}
                                        </div>
                                        @if($waitlist->position == 1)
                                        <br><small class="text-success">Next in line!</small>
                                        @endif
                                    </td>
                                    <td>{{ $waitlist->joined_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('events.guest.show', $waitlist->event) }}" 
                                               class="btn btn-outline-primary" title="View Event">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('events.waitlist.remove', $waitlist) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" 
                                                        onclick="return confirm('Are you sure you want to leave the waitlist?')"
                                                        title="Leave Waitlist">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Waitlist Information -->
                    <div class="alert alert-info mt-3">
                        <h6><i class="fas fa-info-circle me-2"></i> Waitlist Information</h6>
                        <ul class="mb-0">
                            <li>Your position determines when you'll get a seat if one becomes available.</li>
                            <li>You'll be notified by email when a seat becomes available.</li>
                            <li>You have 24 hours to confirm when notified.</li>
                            <li>You can leave the waitlist anytime.</li>
                        </ul>
                    </div>
                </div>
            </div>
            @else
            <div class="ju-card">
                <div class="ju-card-body text-center py-5">
                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No waitlist positions</h4>
                    <p class="text-muted">You're not on any waitlists.</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Past Events Tab -->
        <div class="tab-pane fade" id="past" role="tabpanel">
            @if($registrations->where('event.start_date', '<', now())->count() > 0)
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title m-0">Your Past Events</h5>
                </div>
                <div class="ju-card-body">
                    <div class="table-responsive">
                        <table class="table table-ju">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Attended</th>
                                    <th>Registration No.</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                @if($registration->event->start_date < now())
                                <tr>
                                    <td>
                                        <strong>{{ $registration->event->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $registration->event->organizer }}</small>
                                    </td>
                                    <td>{{ $registration->event->start_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $registration->status_color }}">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($registration->attended)
                                        <span class="badge bg-success"><i class="fas fa-check"></i> Yes</span>
                                        @if($registration->check_in_time)
                                        <br><small>{{ $registration->check_in_time->format('h:i A') }}</small>
                                        @endif
                                        @else
                                        <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <code>{{ $registration->registration_number }}</code>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('events.guest.show', $registration->event) }}" 
                                               class="btn btn-outline-primary" title="View Event">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('event-registration.show', $registration) }}" 
                                               class="btn btn-outline-info" title="View Registration">
                                                <i class="fas fa-ticket-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($registrations->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $registrations->withQueryString()->links() }}
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="ju-card">
                <div class="ju-card-body text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No past events</h4>
                    <p class="text-muted">You haven't attended any events yet.</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="ju-card mt-4">
        <div class="ju-card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    <a href="{{ route('event-registration.index') }}" class="btn btn-ju-outline w-100 py-3">
                        <i class="fas fa-search fa-2x mb-2 d-block"></i>
                        Browse More Events
                    </a>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-ju-outline w-100 py-3">
                        <i class="fas fa-tachometer-alt fa-2x mb-2 d-block"></i>
                        Go to Dashboard
                    </a>
                </div>
                <div class="col-md-4 text-center mb-3">
                    <a href="{{ route('home') }}" class="btn btn-ju-outline w-100 py-3">
                        <i class="fas fa-home fa-2x mb-2 d-block"></i>
                        Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
        font-weight: 500;
        padding: 1rem 1.5rem;
        transition: all 0.3s;
    }
    
    .nav-tabs .nav-link:hover {
        border-bottom-color: #dee2e6;
        color: var(--ju-green);
    }
    
    .nav-tabs .nav-link.active {
        color: var(--ju-green);
        border-bottom-color: var(--ju-green);
        background-color: transparent;
    }
    
    .waitlist-position {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
    }
    
    .tab-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Activate tab based on URL hash
        var hash = window.location.hash;
        if (hash) {
            $('.nav-tabs button[data-bs-target="' + hash + '"]').tab('show');
        }

        // Update URL hash when tab changes
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            window.location.hash = e.target.getAttribute('data-bs-target');
        });
        
        // Initialize DataTable for tables
        $('.table-ju').DataTable({
            "pageLength": 10,
            "responsive": true,
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    });
</script>
@endpush