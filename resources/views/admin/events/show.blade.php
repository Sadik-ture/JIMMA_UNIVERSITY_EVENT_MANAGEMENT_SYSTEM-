@extends('layouts.app')

@section('title', $event->title . ' - Jimma University')

@section('page-title', $event->title)
@section('page-subtitle', 'Event Details')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($event->title, 20) }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="ju-card mb-4">
            <div class="ju-card-header d-flex justify-content-between align-items-center">
                <h5 class="ju-card-title mb-0">Event Information</h5>
                <div class="btn-group">
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this event?')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="ju-card-body">
                @if($event->image)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" 
                         class="img-fluid rounded" style="max-height: 400px;">
                </div>
                @endif
                
                <div class="mb-4">
                    <h4>{{ $event->title }}</h4>
                    <p class="text-muted">{{ $event->description }}</p>
                </div>
                
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
                                <div><strong>Type:</strong> <span class="badge bg-info">{{ ucfirst($event->event_type) }}</span></div>
                                <div><strong>Organizer:</strong> {{ $event->organizer }}</div>
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
                                <div><strong>Visibility:</strong> 
                                    <span class="badge {{ $event->is_public ? 'bg-success' : 'bg-warning' }}">
                                        {{ $event->is_public ? 'Public' : 'Private' }}
                                    </span>
                                </div>
                                <div><strong>Featured:</strong> 
                                    <span class="badge {{ $event->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                        {{ $event->is_featured ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-users text-success me-2"></i> Attendance</h6>
                            <div class="ms-4">
                                <div><strong>Max Attendees:</strong> {{ $event->max_attendees ?: 'Unlimited' }}</div>
                                <div><strong>Registration:</strong> 
                                    <span class="badge {{ $event->requires_registration ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $event->requires_registration ? 'Required' : 'Not Required' }}
                                    </span>
                                </div>
                                @if($event->requires_registration && $event->registration_link)
                                <div><strong>Registration Link:</strong> 
                                    <a href="{{ $event->registration_link }}" target="_blank" class="btn btn-sm btn-link p-0">
                                        Click here to register
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
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
                
                @if($event->tags)
                <div class="mb-3">
                    <h6><i class="fas fa-tags text-orange me-2"></i> Tags</h6>
                    <div class="ms-4">
                        @php
                            // Handle both string and array cases
                            if (is_string($event->tags)) {
                                $tagsArray = array_map('trim', explode(',', $event->tags));
                            } elseif (is_array($event->tags)) {
                                $tagsArray = $event->tags;
                            } else {
                                $tagsArray = [];
                            }
                        @endphp
                        
                        @foreach($tagsArray as $tag)
                            <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="ju-card mb-4">
            <div class="ju-card-header">
                <h6 class="ju-card-title mb-0">Quick Actions</h6>
            </div>
            <div class="ju-card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i> Edit Event
                    </a>
                    
                    <form action="{{ route('admin.events.toggle-featured', $event) }}" method="POST" class="d-grid">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn {{ $event->is_featured ? 'btn-secondary' : 'btn-outline-warning' }}">
                            <i class="fas fa-star me-2"></i> 
                            {{ $event->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        
        <div class="ju-card">
            <div class="ju-card-header">
                <h6 class="ju-card-title mb-0">Event Statistics</h6>
            </div>
            <div class="ju-card-body">
                <div class="mb-3">
                    <small class="text-muted">Created</small>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-plus text-muted me-2"></i>
                        {{ $event->created_at->format('M d, Y') }}
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Last Updated</small>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-history text-muted me-2"></i>
                        {{ $event->updated_at->format('M d, Y') }}
                    </div>
                </div>
                
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
                
                <div class="mb-3">
                    <small class="text-muted">Event URL</small>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" 
                               value="{{ url()->current() }}" readonly>
                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="copyEventUrl()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyEventUrl() {
        const urlInput = document.querySelector('input[type="text"]');
        urlInput.select();
        document.execCommand('copy');
        alert('Event URL copied to clipboard!');
    }
</script>
@endpush