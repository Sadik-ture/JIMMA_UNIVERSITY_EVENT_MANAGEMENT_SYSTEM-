@extends('layouts.app')

@section('title', $event->title . ' - Jimma University Event Management')
@section('page-title', 'Event Details')
@section('page-subtitle', 'Complete information about this event')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('events.guest.dashboard') }}">Events Dashboard</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($event->title, 30) }}</li>
@endsection

@section('content')
<!-- Event Hero Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="row g-0">
                <!-- Event Image -->
                <div class="col-lg-6 position-relative">
                    @if($event->featured_image)
                    <img src="{{ asset('storage/' . $event->featured_image) }}" 
                         class="img-fluid h-100" 
                         alt="{{ $event->title }}"
                         style="object-fit: cover; min-height: 400px;">
                    @else
                    <div class="bg-success bg-opacity-10 d-flex align-items-center justify-content-center h-100 min-vh-50">
                        <div class="text-center p-5">
                            <i class="fas fa-calendar-alt fa-5x text-success opacity-50 mb-4"></i>
                            <h3 class="text-success">{{ $event->title }}</h3>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 start-0 m-4">
                        <span class="badge bg-{{ $event->status == 'ongoing' ? 'danger' : ($event->status == 'upcoming' ? 'success' : 'secondary') }} fs-6 py-2 px-3">
                            @if($event->status == 'ongoing')
                            <i class="fas fa-play-circle me-1"></i> Live Now
                            @elseif($event->status == 'upcoming')
                            <i class="fas fa-clock me-1"></i> Upcoming
                            @else
                            <i class="fas fa-check-circle me-1"></i> Completed
                            @endif
                        </span>
                    </div>
                    
                    <!-- Type Badge -->
                    <div class="position-absolute top-0 end-0 m-4">
                        <span class="badge bg-{{ $event->type_color }} fs-6 py-2 px-3">
                            <i class="fas fa-{{ $event->event_type == 'sports' ? 'futbol' : ($event->event_type == 'cultural' ? 'music' : ($event->event_type == 'academic' ? 'graduation-cap' : 'calendar-day')) }} me-1"></i>
                            {{ ucfirst($event->event_type) }}
                        </span>
                    </div>
                </div>
                
                <!-- Event Summary -->
                <div class="col-lg-6">
                    <div class="card-body p-4 p-lg-5">
                        <div class="mb-4">
                            <h1 class="display-6 fw-bold mb-3">{{ $event->title }}</h1>
                            <p class="lead text-muted mb-4">{{ $event->short_description ?? Str::limit($event->description, 150) }}</p>
                            
                            <div class="d-flex flex-wrap gap-3 mb-4">
                                @if($event->is_featured)
                                <span class="badge bg-warning fs-6 py-2 px-3">
                                    <i class="fas fa-star me-1"></i> Featured Event
                                </span>
                                @endif
                                @if($event->requires_registration)
                                <span class="badge bg-primary fs-6 py-2 px-3">
                                    <i class="fas fa-user-plus me-1"></i> Registration Required
                                </span>
                                @endif
                                @if($event->is_free)
                                <span class="badge bg-success fs-6 py-2 px-3">
                                    <i class="fas fa-tag me-1"></i> Free Entry
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Quick Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-calendar-alt fa-lg text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Event Date</small>
                                        <strong>{{ $event->start_date->format('l, F j, Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-clock fa-lg text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Time</small>
                                        <strong>{{ $event->start_date->format('h:i A') }} - {{ $event->end_date->format('h:i A') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-map-marker-alt fa-lg text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Venue</small>
                                        <strong>{{ $event->venue }}, {{ $event->campus }} Campus</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-users fa-lg text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Attendance</small>
                                        <strong>
                                            {{ $event->registered_attendees }} 
                                            @if($event->max_attendees)
                                            / {{ $event->max_attendees }} registered
                                            @endif
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap gap-3">
                            @if($event->requires_registration && $event->registration_link)
                            <a href="{{ $event->registration_link }}" 
                               target="_blank" 
                               class="btn btn-success btn-lg px-4 py-3">
                                <i class="fas fa-user-plus me-2"></i> Register Now
                            </a>
                            @endif
                            
                            {{-- Line 146 should be: --}}
<a href="{{ route('events.guest.share', $event) }}" 
   class="btn btn-outline-success btn-lg px-4 py-3">
    <i class="fas fa-share-alt me-2"></i> Share Event
</a>
                            
                
{{-- Line 153 should be: --}}
<a href="{{ route('events.guest.export-ics', $event) }}" 
   class="btn btn-outline-success btn-lg px-4 py-3">
    <i class="fas fa-calendar-plus me-2"></i> Add to Calendar
</a>
                            
                            <button class="btn btn-outline-success btn-lg px-4 py-3" onclick="bookmarkEvent()">
                                <i class="fas fa-bookmark me-2"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Event Description -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-4">
                <h3 class="mb-0"><i class="fas fa-align-left text-success me-2"></i>Event Description</h3>
            </div>
            <div class="card-body">
                <div class="event-content">
                    {!! nl2br(e($event->description)) !!}
                </div>
                
                @if($event->tags)
                <div class="mt-4">
                    <h6><i class="fas fa-tags text-success me-2"></i>Tags</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(explode(',', $event->tags) as $tag)
                        <span class="badge bg-light text-dark border py-2 px-3">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Event Schedule -->
        @if($event->schedule)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-4">
                <h3 class="mb-0"><i class="fas fa-list-ol text-success me-2"></i>Event Schedule</h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach(json_decode($event->schedule, true) as $index => $item)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-1">{{ $item['time'] }}</h5>
                                <span class="badge bg-light text-dark">{{ $item['duration'] }}</span>
                            </div>
                            <h6 class="mb-2">{{ $item['title'] }}</h6>
                            <p class="text-muted mb-0">{{ $item['description'] ?? '' }}</p>
                            @if(isset($item['speaker']))
                            <small class="text-success mt-2 d-block">
                                <i class="fas fa-user me-1"></i> {{ $item['speaker'] }}
                            </small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Speakers -->
        @if($event->speakers->count() > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-4">
                <h3 class="mb-0"><i class="fas fa-microphone text-success me-2"></i>Event Speakers</h3>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    @foreach($event->speakers as $speaker)
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                @if($speaker->photo)
                                <img src="{{ asset('storage/' . $speaker->photo) }}" 
                                     alt="{{ $speaker->name }}"
                                     class="rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-user fa-2x text-success"></i>
                                </div>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ $speaker->name }}</h5>
                                <p class="text-success mb-1">{{ $speaker->title }}{{ $speaker->organization ? ' at ' . $speaker->organization : '' }}</p>
                                <p class="text-muted small mb-2">{{ Str::limit($speaker->bio, 100) }}</p>
                                <div class="d-flex gap-2">
                                    @if($speaker->expertise)
                                    <span class="badge bg-light text-dark">{{ $speaker->expertise }}</span>
                                    @endif
                                    @if($speaker->linkedin_url)
                                    <a href="{{ $speaker->linkedin_url }}" target="_blank" class="text-muted">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Location & Map -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-4">
                <h3 class="mb-0"><i class="fas fa-map-marked-alt text-success me-2"></i>Location & Directions</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{ $event->venue }}</h5>
                        <p class="text-muted mb-4">{{ $event->location_details ?? 'Jimma University ' . $event->campus . ' Campus' }}</p>
                        
                        <div class="mb-3">
                            <h6><i class="fas fa-directions text-success me-2"></i>Getting There</h6>
                            <p class="text-muted small">{{ $event->directions ?? 'Use the main university entrance and follow signs to the event venue.' }}</p>
                        </div>
                        
                        @if($event->parking_info)
                        <div class="mb-3">
                            <h6><i class="fas fa-parking text-success me-2"></i>Parking Information</h6>
                            <p class="text-muted small">{{ $event->parking_info }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div id="map" style="height: 300px; border-radius: 10px; overflow: hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Organizer Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0"><i class="fas fa-user-tie text-success me-2"></i>Organizer</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @if($event->organizer_logo)
                    <img src="{{ asset('storage/' . $event->organizer_logo) }}" 
                         alt="{{ $event->organizer }}"
                         class="img-fluid mb-3"
                         style="max-height: 80px;">
                    @endif
                    <h5>{{ $event->organizer }}</h5>
                    <p class="text-muted small mb-0">{{ $event->organizer_department ?? 'University Event' }}</p>
                </div>
                
                <div class="border-top pt-3">
                    <div class="row g-2">
                        @if($event->contact_email)
                        <div class="col-12">
                            <small class="text-muted d-block">Email</small>
                            <a href="mailto:{{ $event->contact_email }}" class="text-success">
                                {{ $event->contact_email }}
                            </a>
                        </div>
                        @endif
                        
                        @if($event->contact_phone)
                        <div class="col-12">
                            <small class="text-muted d-block">Phone</small>
                            <a href="tel:{{ $event->contact_phone }}" class="text-success">
                                {{ $event->contact_phone }}
                            </a>
                        </div>
                        @endif
                        
                        @if($event->website)
                        <div class="col-12">
                            <small class="text-muted d-block">Website</small>
                            <a href="{{ $event->website }}" target="_blank" class="text-success">
                                {{ parse_url($event->website, PHP_URL_HOST) }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Stats -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0"><i class="fas fa-chart-line text-success me-2"></i>Attendance Stats</h5>
            </div>
            <div class="card-body">
                @if($event->max_attendees)
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Registration Progress</span>
                        <span class="fw-bold">
                            {{ $event->registered_attendees }} / {{ $event->max_attendees }}
                        </span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        @php
                            $percentage = ($event->registered_attendees / $event->max_attendees) * 100;
                            $progressClass = $percentage > 80 ? 'bg-danger' : ($percentage > 50 ? 'bg-warning' : 'bg-success');
                        @endphp
                        <div class="progress-bar {{ $progressClass }}" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endif
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="display-6 fw-bold text-success">{{ $event->views_count ?? 0 }}</div>
                        <small class="text-muted">Views</small>
                    </div>
                    <div class="col-6">
                        <div class="display-6 fw-bold text-success">{{ $event->shares_count ?? 0 }}</div>
                        <small class="text-muted">Shares</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Dates -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0"><i class="fas fa-calendar-check text-success me-2"></i>Important Dates</h5>
            </div>
            <div class="card-body">
                <div class="timeline-vertical">
                    <div class="timeline-item-vertical">
                        <div class="timeline-marker-vertical bg-success"></div>
                        <div class="timeline-content-vertical">
                            <small class="text-muted">Registration Opens</small>
                            <div class="fw-bold">{{ $event->registration_opens ? \Carbon\Carbon::parse($event->registration_opens)->format('M d, Y') : 'Immediately' }}</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item-vertical">
                        <div class="timeline-marker-vertical bg-success"></div>
                        <div class="timeline-content-vertical">
                            <small class="text-muted">Registration Closes</small>
                            <div class="fw-bold">{{ $event->registration_closes ? \Carbon\Carbon::parse($event->registration_closes)->format('M d, Y') : 'Event Start' }}</div>
                        </div>
                    </div>
                    
                    <div class="timeline-item-vertical">
                        <div class="timeline-marker-vertical bg-success"></div>
                        <div class="timeline-content-vertical">
                            <small class="text-muted">Event Date</small>
                            <div class="fw-bold">{{ $event->start_date->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Events -->
        @if($similarEvents->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0"><i class="fas fa-calendar-plus text-success me-2"></i>Similar Events</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($similarEvents as $similarEvent)
                    <a href="{{ route('events.guest.show', $similarEvent->slug) }}" 
                       class="list-group-item list-group-item-action border-0 px-0 py-3">
                        <div class="d-flex align-items-start">
                            @if($similarEvent->featured_image)
                            <img src="{{ asset('storage/' . $similarEvent->featured_image) }}" 
                                 class="rounded me-3"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                            <div class="bg-success bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3"
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-calendar-day text-success"></i>
                            </div>
                            @endif
                            <div>
                                <h6 class="mb-1">{{ Str::limit($similarEvent->title, 40) }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $similarEvent->start_date->format('M d') }}
                                    <i class="fas fa-clock ms-2 me-1"></i>
                                    {{ $similarEvent->start_date->format('h:i A') }}
                                </small>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Related Documents -->
@if($event->documents->count() > 0)
<div class="row mt-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-4">
                <h3 class="mb-0"><i class="fas fa-file-alt text-success me-2"></i>Event Documents</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($event->documents as $document)
                    <div class="col-md-4">
                        <div class="card border h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        @switch($document->type)
                                            @case('pdf')
                                                <i class="fas fa-file-pdf fa-lg text-danger"></i>
                                                @break
                                            @case('word')
                                                <i class="fas fa-file-word fa-lg text-primary"></i>
                                                @break
                                            @case('excel')
                                                <i class="fas fa-file-excel fa-lg text-success"></i>
                                                @break
                                            @default
                                                <i class="fas fa-file fa-lg text-success"></i>
                                        @endswitch
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $document->name }}</h6>
                                        <small class="text-muted">{{ $document->size }} • {{ $document->type }}</small>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ asset('storage/' . $document->path) }}" 
                                       class="btn btn-sm btn-outline-success w-100"
                                       download>
                                        <i class="fas fa-download me-2"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        top: 5px;
    }
    
    .timeline-content {
        padding-left: 15px;
        border-left: 2px solid #e9ecef;
    }
    
    .timeline-vertical {
        position: relative;
    }
    
    .timeline-item-vertical {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-marker-vertical {
        position: absolute;
        left: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        top: 5px;
    }
    
    .timeline-content-vertical {
        padding-left: 25px;
    }
    
    .event-content {
        line-height: 1.8;
    }
    
    .event-content p {
        margin-bottom: 1rem;
    }
    
    .min-vh-50 {
        min-height: 400px;
    }
</style>
@endpush

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
<script>
    // Initialize map
    function initMap() {
        const eventLocation = { lat: {{ $event->latitude ?? 7.6667 }}, lng: {{ $event->longitude ?? 36.8333 }} };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: eventLocation,
            styles: [
                {
                    "featureType": "poi",
                    "elementType": "labels",
                    "stylers": [{ "visibility": "off" }]
                }
            ]
        });
        
        new google.maps.Marker({
            position: eventLocation,
            map: map,
            title: "{{ $event->venue }}",
            icon: {
                url: "{{ asset('images/map-marker.png') }}",
                scaledSize: new google.maps.Size(40, 40)
            }
        });
    }

    // Bookmark event
    function bookmarkEvent() {
        fetch('{{ route("events.bookmark", $event->slug) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const toast = new bootstrap.Toast(document.getElementById('bookmarkToast'));
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = data.message;
            toast.show();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Countdown timer for upcoming events
    @if($event->status == 'upcoming')
    function updateCountdown() {
        const eventDate = new Date('{{ $event->start_date->toIso8601String() }}').getTime();
        const now = new Date().getTime();
        const distance = eventDate - now;
        
        if (distance < 0) {
            document.getElementById("countdown").innerHTML = "Event Started!";
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById("countdown").innerHTML = `
            <div class="row g-2 text-center">
                <div class="col-3">
                    <div class="display-6 fw-bold">${days}</div>
                    <small>Days</small>
                </div>
                <div class="col-3">
                    <div class="display-6 fw-bold">${hours}</div>
                    <small>Hours</small>
                </div>
                <div class="col-3">
                    <div class="display-6 fw-bold">${minutes}</div>
                    <small>Minutes</small>
                </div>
                <div class="col-3">
                    <div class="display-6 fw-bold">${seconds}</div>
                    <small>Seconds</small>
                </div>
            </div>
        `;
    }
    
    // Update countdown every second
    setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial call
    @endif

    // Add event to calendar
    function addToCalendar() {
        const icsContent = `BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Jimma University//Event Management//EN
BEGIN:VEVENT
SUMMARY:{{ $event->title }}
DESCRIPTION:{{ Str::limit($event->description, 200) }}
DTSTART:{{ $event->start_date->format('Ymd\THis') }}
DTEND:{{ $event->end_date->format('Ymd\THis') }}
LOCATION:{{ $event->venue }}, {{ $event->campus }}
END:VEVENT
END:VCALENDAR`;
        
        const blob = new Blob([icsContent], { type: 'text/calendar' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'event.ics';
        link.click();
    }
</script>
@endpush

<!-- Toast Notification -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="bookmarkToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <span id="toastMessage">Event bookmarked successfully!</span>
        </div>
    </div>
</div>

<!-- Countdown Timer (for upcoming events) -->
@if($event->status == 'upcoming')
<div class="modal fade" id="countdownModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Event Countdown</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-center mb-3">The event starts in:</p>
                <div id="countdown"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownModal = new bootstrap.Modal(document.getElementById('countdownModal'));
        countdownModal.show();
    });
</script>
@endif