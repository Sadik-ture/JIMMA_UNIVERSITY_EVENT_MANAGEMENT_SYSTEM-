@extends('layouts.app')

@section('title', $event->title . ' - Jimma University')
@section('page-title', $event->title)
@section('page-subtitle', 'Event Details')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('events.guest.dashboard') }}">Events</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($event->title, 30) }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Event Header -->
        <div class="ju-card mb-4">
            <div class="ju-card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <span class="badge bg-primary mb-2">{{ ucfirst($event->event_type) }}</span>
                            @if($event->is_featured)
                                <span class="badge bg-warning mb-2">Featured</span>
                            @endif
                            <h1 class="h3">{{ $event->title }}</h1>
                            <p class="text-muted">{{ $event->description }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <!-- Share Button -->
                        <button class="btn btn-ju-outline mb-2" onclick="shareEvent()">
                            <i class="fas fa-share-alt me-2"></i> Share Event
                        </button>
                        @if($event->requires_registration && $event->registration_link)
                            <a href="{{ $event->registration_link }}" target="_blank" class="btn btn-ju">
                                <i class="fas fa-user-plus me-2"></i> Register Now
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="ju-card mb-4">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0">Event Information</h5>
            </div>
            <div class="ju-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6><i class="fas fa-calendar-alt text-primary me-2"></i> Date & Time</h6>
                            <div class="ms-4">
                                <div><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('l, F j, Y \a\t h:i A') }}</div>
                                <div><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('l, F j, Y \a\t h:i A') }}</div>
                                <div><strong>Duration:</strong> {{ \Carbon\Carbon::parse($event->start_date)->diffForHumans($event->end_date, true) }}</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-map-marker-alt text-danger me-2"></i> Location</h6>
                            <div class="ms-4">
                                <div><strong>Venue:</strong> {{ $event->venue }}</div>
                                @if($event->campus)
                                <div><strong>Campus:</strong> {{ ucfirst($event->campus) }} Campus</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6><i class="fas fa-info-circle text-info me-2"></i> Event Details</h6>
                            <div class="ms-4">
                                <div><strong>Organizer:</strong> {{ $event->organizer }}</div>
                                <div><strong>Type:</strong> <span class="badge bg-info">{{ ucfirst($event->event_type) }}</span></div>
                                <div><strong>Status:</strong> 
                                    @php
                                        $now = now();
                                        $start = \Carbon\Carbon::parse($event->start_date);
                                        $end = \Carbon\Carbon::parse($event->end_date);
                                        
                                        if ($now < $start) {
                                            $status = 'Upcoming';
                                            $badgeClass = 'bg-primary';
                                        } elseif ($now >= $start && $now <= $end) {
                                            $status = 'Ongoing';
                                            $badgeClass = 'bg-success';
                                        } else {
                                            $status = 'Completed';
                                            $badgeClass = 'bg-secondary';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                </div>
                                @if($event->max_attendees)
                                <div><strong>Capacity:</strong> {{ $event->max_attendees }} attendees</div>
                                @endif
                            </div>
                        </div>
                        
                        @if($event->contact_email || $event->contact_phone)
                        <div class="mb-3">
                            <h6><i class="fas fa-address-book text-purple me-2"></i> Contact Information</h6>
                            <div class="ms-4">
                                @if($event->contact_email)
                                <div><strong>Email:</strong> <a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a></div>
                                @endif
                                @if($event->contact_phone)
                                <div><strong>Phone:</strong> <a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a></div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Speakers -->
        @if($event->speakers->count() > 0)
        <div class="ju-card mb-4">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0">Event Speakers</h5>
            </div>
            <div class="ju-card-body">
                <div class="row">
                    @foreach($event->speakers as $speaker)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="d-flex align-items-start">
                            @if($speaker->photo)
                            <img src="{{ asset('storage/' . $speaker->photo) }}" alt="{{ $speaker->name }}" 
                                 class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background: var(--ju-light-green); color: var(--ju-green);">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $speaker->name }}</h6>
                                <p class="text-muted small mb-1">{{ $speaker->title }}</p>
                                <p class="text-muted small mb-0">{{ $speaker->department }}</p>
                                @if($speaker->expertise)
                                <span class="badge bg-light text-dark small">{{ $speaker->expertise }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-lg-4">
        <!-- Event Image -->
        <div class="ju-card mb-4">
            <div class="ju-card-body">
                @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" 
                     class="img-fluid rounded mb-3">
                @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                    <p class="text-muted">No image available</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Info -->
        <div class="ju-card mb-4">
            <div class="ju-card-header">
                <h6 class="ju-card-title mb-0">Quick Info</h6>
            </div>
            <div class="ju-card-body">
                <div class="mb-3">
                    <small class="text-muted">Days Until Event</small>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock text-muted me-2"></i>
                        @php
                            $days = \Carbon\Carbon::parse($event->start_date)->diffInDays(now());
                            if ($days == 0) {
                                echo 'Today';
                            } else {
                                echo $days . ' day' . ($days == 1 ? '' : 's');
                            }
                        @endphp
                    </div>
                </div>
                
                @if($event->tags && count($event->tags) > 0)
                <div class="mb-3">
                    <small class="text-muted">Tags</small>
                    <div class="mt-1">
                        @foreach($event->tags as $tag)
                            <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="mb-3">
                    <small class="text-muted">Event URL</small>
                    <div class="input-group input-group-sm mt-1">
                        <input type="text" class="form-control" value="{{ url()->current() }}" readonly id="eventUrl">
                        <button class="btn btn-outline-secondary" type="button" onclick="copyEventUrl()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Events -->
        @if(isset($similarEvents) && $similarEvents->count() > 0)
        <div class="ju-card">
            <div class="ju-card-header">
                <h6 class="ju-card-title mb-0">Similar Events</h6>
            </div>
            <div class="ju-card-body">
                @foreach($similarEvents as $similarEvent)
                <div class="mb-3">
                    <h6 class="mb-1">{{ $similarEvent->title }}</h6>
                    <small class="text-muted d-block">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($similarEvent->start_date)->format('M d, Y') }}
                    </small>
                    <small class="text-muted d-block">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $similarEvent->venue }}
                    </small>
                    <a href="{{ route('events.guest.show', $similarEvent) }}" class="btn btn-sm btn-ju-outline mt-2">
                        View Details
                    </a>
                </div>
                @if(!$loop->last)
                <hr class="my-2">
                @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyEventUrl() {
        const urlInput = document.getElementById('eventUrl');
        urlInput.select();
        document.execCommand('copy');
        alert('Event URL copied to clipboard!');
    }
    
    function shareEvent() {
        const eventTitle = '{{ $event->title }}';
        const eventUrl = '{{ url()->current() }}';
        const shareText = `Check out this event: ${eventTitle}`;
        
        if (navigator.share) {
            // Use Web Share API if available
            navigator.share({
                title: eventTitle,
                text: shareText,
                url: eventUrl,
            })
            .catch(console.error);
        } else {
            // Fallback: Show share options
            const shareModal = `
                <div class="modal fade" id="shareModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Share Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Share Link</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="${eventUrl}" readonly>
                                        <button class="btn btn-ju" onclick="copyEventUrl()">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <h6>Share via:</h6>
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(eventUrl)}" 
                                           target="_blank" class="btn btn-outline-primary">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodeURIComponent(eventUrl)}" 
                                           target="_blank" class="btn btn-outline-info">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="https://wa.me/?text=${encodeURIComponent(shareText + ' ' + eventUrl)}" 
                                           target="_blank" class="btn btn-outline-success">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(eventUrl)}" 
                                           target="_blank" class="btn btn-outline-dark">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Create and show modal
            const modalContainer = document.createElement('div');
            modalContainer.innerHTML = shareModal;
            document.body.appendChild(modalContainer);
            
            const modal = new bootstrap.Modal(document.getElementById('shareModal'));
            modal.show();
            
            // Remove modal after hiding
            document.getElementById('shareModal').addEventListener('hidden.bs.modal', function () {
                modalContainer.remove();
            });
        }
    }
</script>
@endpush