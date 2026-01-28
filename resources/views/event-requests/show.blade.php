@extends('layouts.app')

@section('title', 'Event Request #' . $eventRequest->id . ' - JU Event Management')

@section('content')
<div class="container-fluid px-4">
    <div class="row my-4">
        <div class="col-12">
            <div class="card ju-card">
                <div class="card-header ju-card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">
                            <i class="fas fa-clipboard me-2"></i>Event Request #{{ $eventRequest->id }}
                        </h4>
                        <p class="mb-0 text-muted">
                            Submitted by {{ $eventRequest->user->name }} on 
                            {{ $eventRequest->created_at->format('F d, Y \a\t h:i A') }}
                        </p>
                    </div>
                    <div>
                        <span class="badge bg-{{ $eventRequest->status_color }} fs-6">
                            {{ ucfirst($eventRequest->status) }}
                        </span>
                        @if($eventRequest->event_id)
                        <span class="badge bg-success ms-2 fs-6">
                            <i class="fas fa-check-circle me-1"></i> Event Created
                        </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column: Request Details -->
                        <div class="col-md-8">
                            <!-- Event Details -->
                            <div class="card ju-card-light mb-4">
                                <div class="card-header ju-card-subheader">
                                    <h5 class="mb-0">Event Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Event Title</h6>
                                            <p class="fs-5">{{ $eventRequest->title }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Event Type</h6>
                                            <p>
                                                <span class="badge ju-badge">{{ ucfirst($eventRequest->event_type) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Description</h6>
                                        <p>{{ $eventRequest->description }}</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Proposed Dates</h6>
                                            <p class="mb-1">
                                                <strong>Start:</strong> 
                                                {{ $eventRequest->proposed_start_date->format('F d, Y') }}
                                            </p>
                                            <p class="mb-0">
                                                <strong>End:</strong> 
                                                {{ $eventRequest->proposed_end_date->format('F d, Y') }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Venue</h6>
                                            <p class="mb-1">{{ $eventRequest->proposed_venue }}</p>
                                            @if($eventRequest->proposed_campus)
                                            <p class="mb-0 text-muted">{{ $eventRequest->proposed_campus }} Campus</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($eventRequest->expected_attendees)
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Expected Attendees</h6>
                                            <p>{{ number_format($eventRequest->expected_attendees) }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($eventRequest->additional_requirements)
                                    <div class="mt-3">
                                        <h6 class="text-muted mb-2">Additional Requirements</h6>
                                        <p>{{ $eventRequest->additional_requirements }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Organizer Information -->
                            <div class="card ju-card-light mb-4">
                                <div class="card-header ju-card-subheader">
                                    <h5 class="mb-0">Organizer Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-2">Organizer Name</h6>
                                            <p>{{ $eventRequest->organizer_name }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-2">Organizer Email</h6>
                                            <p>{{ $eventRequest->organizer_email }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($eventRequest->organizer_phone)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-muted mb-2">Organizer Phone</h6>
                                            <p>{{ $eventRequest->organizer_phone }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Created Event (if approved) -->
                            @if($eventRequest->isApproved() && $eventRequest->event)
                            <div class="card ju-card-light mb-4">
                                <div class="card-header ju-card-subheader bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-check-circle me-2"></i>Created Event
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-success">
                                        <p class="mb-2">This request has been approved and an event has been created.</p>
                                        <a href="{{ route('admin.events.show', $eventRequest->event) }}" class="btn btn-sm btn-light">class="btn btn-sm btn-light">
                                            <i class="fas fa-external-link-alt me-1"></i> View Event
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Review Information -->
                            @if($eventRequest->isApproved() || $eventRequest->isRejected())
                            <div class="card ju-card-light">
                                <div class="card-header ju-card-subheader">
                                    <h5 class="mb-0">Review Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-2">Reviewed By</h6>
                                            <p>{{ $eventRequest->reviewer->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-muted mb-2">Reviewed On</h6>
                                            <p>{{ $eventRequest->reviewed_at?->format('F d, Y \a\t h:i A') ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($eventRequest->review_notes)
                                    <div>
                                        <h6 class="text-muted mb-2">Review Notes</h6>
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <p class="mb-0">{{ $eventRequest->review_notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Right Column: Actions & Timeline -->
                        <div class="col-md-4">
                            <!-- Actions -->
                            <div class="card ju-card-light mb-4">
                                <div class="card-header ju-card-subheader">
                                    <h5 class="mb-0">Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        @if($eventRequest->isPending() && ($eventRequest->user_id == auth()->id() || auth()->user()->hasPermission('manage_events')))
                                        <a href="{{ route('event-requests.edit', $eventRequest) }}" 
                                           class="btn ju-btn-primary">
                                            <i class="fas fa-edit me-1"></i> Edit Request
                                        </a>
                                        @endif
                                        
                                        @if($eventRequest->isPending() && $eventRequest->user_id == auth()->id())
                                        <form action="{{ route('event-requests.cancel', $eventRequest) }}" 
                                              method="POST" onsubmit="return confirm('Are you sure you want to cancel this request?')">
                                            @csrf
                                            <button type="submit" class="btn btn-warning w-100">
                                                <i class="fas fa-times me-1"></i> Cancel Request
                                            </button>
                                        </form>
                                        @endif
                                        
                                        @if(auth()->user()->hasPermission('manage_events'))
                                            @if($eventRequest->isPending())
                                            <button type="button" class="btn btn-success w-100" 
                                                    data-bs-toggle="modal" data-bs-target="#approveModal">
                                                <i class="fas fa-check me-1"></i> Approve Request
                                            </button>
                                            
                                            <button type="button" class="btn btn-danger w-100" 
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal">
                                                <i class="fas fa-times-circle me-1"></i> Reject Request
                                            </button>
                                            @endif
                                        @endif
                                        
                                        <a href="{{ route('event-requests.index') }}" class="btn ju-btn-outline">
                                            <i class="fas fa-arrow-left me-1"></i> Back to List
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Timeline -->
                            <div class="card ju-card-light mb-4">
                                <div class="card-header ju-card-subheader">
                                    <h5 class="mb-0">Request Timeline</h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item {{ $eventRequest->status == 'pending' ? 'active' : '' }}">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Request Submitted</h6>
                                                <p class="text-muted mb-0">{{ $eventRequest->created_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                        </div>
                                        
                                        @if($eventRequest->isApproved() || $eventRequest->isRejected())
                                        <div class="timeline-item active">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Request {{ ucfirst($eventRequest->status) }}</h6>
                                                <p class="text-muted mb-0">{{ $eventRequest->reviewed_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($eventRequest->isApproved() && $eventRequest->event)
                                        <div class="timeline-item active">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">Event Created</h6>
                                                <p class="text-muted mb-0">{{ $eventRequest->event->created_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Request Information -->
                            <div class="card ju-card-light">
                                <div class="card-header ju-card-subheader">
                                    <h5 class="mb-0">Request Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Request ID</h6>
                                        <p class="mb-0">#{{ $eventRequest->id }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Submitted By</h6>
                                        <p class="mb-0">{{ $eventRequest->user->name }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Submission Date</h6>
                                        <p class="mb-0">{{ $eventRequest->created_at->format('F d, Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <h6 class="text-muted mb-2">Last Updated</h6>
                                        <p class="mb-0">{{ $eventRequest->updated_at->format('F d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
@if(auth()->user()->hasPermission('manage_events') && $eventRequest->isPending())
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ju-modal-header">
                <h5 class="modal-title">Approve Event Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('event-requests.approve', $eventRequest) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to approve this event request?</p>
                    <div class="mb-3">
                        <label for="review_notes" class="form-label">Review Notes (Optional)</label>
                        <textarea class="form-control ju-input" id="review_notes" 
                                  name="review_notes" rows="3"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" 
                               id="make_public" name="make_public" value="1" checked>
                        <label class="form-check-label" for="make_public">
                            Make event public
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               id="is_featured" name="is_featured" value="1">
                        <label class="form-check-label" for="is_featured">
                            Mark as featured event
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn ju-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn ju-btn-success">Approve Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Reject Modal -->
@if(auth()->user()->hasPermission('manage_events') && $eventRequest->isPending())
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ju-modal-header">
                <h5 class="modal-title">Reject Event Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('event-requests.reject', $eventRequest) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to reject this event request?</p>
                    <div class="mb-3">
                        <label for="reject_notes" class="form-label">Reason for Rejection *</label>
                        <textarea class="form-control ju-input" id="reject_notes" 
                                  name="review_notes" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn ju-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn ju-btn-danger">Reject Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 1.5rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: -1.5rem;
    top: 0;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background-color: #adb5bd;
    border: 2px solid white;
}

.timeline-item.active .timeline-marker {
    background-color: var(--ju-primary);
}

.timeline-content {
    padding-left: 0.5rem;
}
</style>
@endpush