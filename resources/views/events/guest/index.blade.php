@extends('layouts.app')

@section('title', 'Browse Events - Jimma University')
@section('page-title', 'Browse All Events')
@section('page-subtitle', 'Find events that match your interests')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('events.guest.dashboard') }}">Events Dashboard</a></li>
    <li class="breadcrumb-item active">Browse Events</li>
@endsection

@section('content')
<!-- Advanced Filter Bar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('events.guest.index') }}" id="advancedFilterForm">
            <div class="row g-3">
                <!-- Quick Search -->
                <div class="col-lg-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" name="search" 
                               placeholder="Search events..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Campus Filter -->
                <div class="col-lg-2">
                    <select class="form-select" name="campus">
                        <option value="">All Campuses</option>
                        @foreach($campuses as $campus)
                        <option value="{{ $campus }}" {{ request('campus') == $campus ? 'selected' : '' }}>
                            {{ $campus }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Event Type -->
                <div class="col-lg-2">
                    <select class="form-select" name="event_type">
                        <option value="">All Types</option>
                        @foreach($eventTypes as $type)
                        <option value="{{ $type }}" {{ request('event_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Filter -->
                <div class="col-lg-2">
                    <select class="form-select" name="date_range">
                        <option value="">Any Date</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="upcoming" {{ request('date_range') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    </select>
                </div>

                <!-- Sort Options -->
                <div class="col-lg-2">
                    <select class="form-select" name="sort">
                        <option value="start_date" {{ request('sort') == 'start_date' ? 'selected' : '' }}>Sort by Date</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Sort by Title</option>
                        <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Most Popular</option>
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Recently Added</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-lg-1">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-fill">
                            <i class="fas fa-filter"></i>
                        </button>
                        <a href="{{ route('events.guest.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Advanced Options Toggle -->
            <div class="row mt-3" id="advancedOptions" style="display: none;">
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Audience Type</label>
                            <select class="form-select" name="audience">
                                <option value="">All Audiences</option>
                                <option value="students">Students</option>
                                <option value="faculty">Faculty</option>
                                <option value="staff">Staff</option>
                                <option value="public">Public</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Registration Status</label>
                            <select class="form-select" name="registration">
                                <option value="">Any</option>
                                <option value="required">Registration Required</option>
                                <option value="free">Free Entry</option>
                                <option value="paid">Paid Event</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Event Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <!-- Event Type Categories -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="fas fa-tags text-success me-2"></i>Browse by Category</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('events.guest.index', ['event_type' => 'academic']) }}" 
                       class="btn btn-outline-primary btn-sm {{ request('event_type') == 'academic' ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap me-2"></i>Academic
                    </a>
                    <a href="{{ route('events.guest.index', ['event_type' => 'cultural']) }}" 
                       class="btn btn-outline-warning btn-sm {{ request('event_type') == 'cultural' ? 'active' : '' }}">
                        <i class="fas fa-music me-2"></i>Cultural
                    </a>
                    <a href="{{ route('events.guest.index', ['event_type' => 'sports']) }}" 
                       class="btn btn-outline-success btn-sm {{ request('event_type') == 'sports' ? 'active' : '' }}">
                        <i class="fas fa-futbol me-2"></i>Sports
                    </a>
                    <a href="{{ route('events.guest.index', ['event_type' => 'conference']) }}" 
                       class="btn btn-outline-info btn-sm {{ request('event_type') == 'conference' ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i>Conference
                    </a>
                    <a href="{{ route('events.guest.index', ['event_type' => 'workshop']) }}" 
                       class="btn btn-outline-danger btn-sm {{ request('event_type') == 'workshop' ? 'active' : '' }}">
                        <i class="fas fa-tools me-2"></i>Workshop
                    </a>
                    <a href="{{ route('events.guest.index', ['event_type' => 'seminar']) }}" 
                       class="btn btn-outline-dark btn-sm {{ request('event_type') == 'seminar' ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Seminar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="col-12">
        <!-- View Controls -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0">
                    <i class="fas fa-calendar-alt text-success me-2"></i>
                    {{ request('event_type') ? ucfirst(request('event_type')) . ' Events' : 'All Events' }}
                </h4>
                <p class="text-muted mb-0 small">
                    Showing {{ $events->firstItem() }} - {{ $events->lastItem() }} of {{ $events->total() }} events
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active" onclick="changeView('grid')">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="changeView('list')">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
                <a href="#calendarModal" class="btn btn-outline-success" data-bs-toggle="modal">
                    <i class="fas fa-calendar me-2"></i>Calendar View
                </a>
            </div>
        </div>

        <!-- Events Grid View -->
        <div id="gridView">
            @if($events->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach($events as $event)
                <div class="col">
                    <div class="card border-0 shadow-sm h-100 event-card">
                        <div class="position-relative">
                            <!-- Event Image -->
                            @if($event->featured_image)
                            <img src="{{ asset('storage/' . $event->featured_image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $event->title }}"
                                 style="height: 180px; object-fit: cover;">
                            @else
                            <div class="card-img-top bg-success bg-opacity-10 d-flex align-items-center justify-content-center" 
                                 style="height: 180px;">
                                <i class="fas fa-{{ $event->event_type == 'sports' ? 'futbol' : ($event->event_type == 'cultural' ? 'music' : ($event->event_type == 'academic' ? 'graduation-cap' : 'calendar-day')) }} fa-3x text-success opacity-50"></i>
                            </div>
                            @endif

                            <!-- Badges -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-{{ $event->type_color }} text-white">
                                    {{ ucfirst($event->event_type) }}
                                </span>
                            </div>

                            @if($event->is_featured)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning">
                                    <i class="fas fa-star me-1"></i>Featured
                                </span>
                            </div>
                            @endif

                            @if($event->status == 'ongoing')
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <span class="badge bg-danger pulse-animation">
                                    <i class="fas fa-play-circle me-1"></i>Live Now
                                </span>
                            </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <!-- Event Title & Description -->
                            <h5 class="card-title mb-2">{{ Str::limit($event->title, 60) }}</h5>
                            <p class="card-text text-muted small mb-3">
                                {{ Str::limit($event->description, 100) }}
                            </p>

                            <!-- Event Details -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar text-success me-1"></i>
                                        {{ $event->start_date->format('M d, Y') }}
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-clock text-success me-1"></i>
                                        {{ $event->start_date->format('h:i A') }}
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-map-marker-alt text-success me-1"></i>
                                        {{ Str::limit($event->venue, 20) }}
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-users text-success me-1"></i>
                                        {{ $event->registered_attendees }} attending
                                    </small>
                                </div>
                            </div>

                            <!-- Progress Bar (if limited capacity) -->
                            @if($event->max_attendees)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Attendance</span>
                                    <span>{{ $event->registered_attendees }}/{{ $event->max_attendees }}</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    @php
                                        $percentage = ($event->registered_attendees / $event->max_attendees) * 100;
                                    @endphp
                                    <div class="progress-bar bg-{{ $percentage > 80 ? 'danger' : ($percentage > 50 ? 'warning' : 'success') }}" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('events.guest.show', $event->slug) }}" 
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            type="button" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('events.share', $event->slug) }}">
                                                <i class="fas fa-share-alt me-2"></i>Share Event
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('events.export.ics', $event->slug) }}">
                                                <i class="fas fa-calendar-plus me-2"></i>Add to Calendar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-bookmark me-2"></i>Save Event
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="reportEvent({{ $event->id }})">
                                                <i class="fas fa-flag me-2"></i>Report Event
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-calendar-times fa-4x text-muted opacity-25"></i>
                </div>
                <h4 class="text-muted mb-3">No Events Found</h4>
                <p class="text-muted mb-4">Try adjusting your search or filter criteria.</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('events.guest.index') }}" class="btn btn-success">
                        <i class="fas fa-redo me-2"></i>Clear Filters
                    </a>
                    <a href="{{ route('events.guest.dashboard') }}" class="btn btn-outline-success">
                        <i class="fas fa-home me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Events List View (Hidden by default) -->
        <div id="listView" style="display: none;">
            @if($events->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($events as $event)
                        <div class="list-group-item list-group-item-action border-0 py-4">
                            <div class="row align-items-center">
                                <!-- Date Column -->
                                <div class="col-md-2 text-center">
                                    <div class="bg-success bg-opacity-10 rounded p-3">
                                        <div class="text-success fw-bold">{{ $event->start_date->format('M') }}</div>
                                        <div class="fs-4 fw-bold">{{ $event->start_date->format('d') }}</div>
                                        <div class="text-muted small">{{ $event->start_date->format('Y') }}</div>
                                    </div>
                                </div>

                                <!-- Event Info -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start mb-2">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $event->title }}</h6>
                                            <p class="text-muted small mb-2">{{ Str::limit($event->description, 120) }}</p>
                                            
                                            <div class="d-flex flex-wrap gap-2">
                                                <span class="badge bg-{{ $event->type_color }}">{{ ucfirst($event->event_type) }}</span>
                                                <span class="badge bg-secondary">{{ $event->campus }}</span>
                                                @if($event->requires_registration)
                                                <span class="badge bg-warning">Registration Required</span>
                                                @endif
                                                @if($event->is_featured)
                                                <span class="badge bg-warning"><i class="fas fa-star me-1"></i>Featured</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Time & Location -->
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <small><i class="fas fa-clock text-success me-1"></i> 
                                            {{ $event->start_date->format('h:i A') }}
                                        </small>
                                    </div>
                                    <div class="mb-2">
                                        <small><i class="fas fa-map-marker-alt text-success me-1"></i> 
                                            {{ $event->venue }}
                                        </small>
                                    </div>
                                    <div>
                                        <small><i class="fas fa-users text-success me-1"></i> 
                                            {{ $event->registered_attendees }} attending
                                        </small>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="col-md-2 text-end">
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('events.guest.show', $event->slug) }}" 
                                           class="btn btn-sm btn-success">
                                            View Details
                                        </a>
                                        <a href="{{ route('events.share', $event->slug) }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-share-alt"></i> Share
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="row mt-5">
            <div class="col-md-12">
                <nav aria-label="Page navigation">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Page {{ $events->currentPage() }} of {{ $events->lastPage() }}
                        </div>
                        {{ $events->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Calendar Modal -->
<div class="modal fade" id="calendarModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-calendar-alt me-2"></i>Events Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="calendarView"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .event-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 100, 0, 0.15) !important;
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    .list-group-item {
        transition: background-color 0.2s;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .progress {
        border-radius: 10px;
    }

    .progress-bar {
        border-radius: 10px;
    }

    .btn-outline-primary.active {
        background-color: #0d6efd;
        color: white;
    }

    .btn-outline-warning.active {
        background-color: #ffc107;
        color: black;
    }

    .btn-outline-success.active {
        background-color: #198754;
        color: white;
    }

    .btn-outline-info.active {
        background-color: #0dcaf0;
        color: black;
    }

    .btn-outline-danger.active {
        background-color: #dc3545;
        color: white;
    }

    .btn-outline-dark.active {
        background-color: #212529;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View toggle functionality
        window.changeView = function(view) {
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const gridBtn = document.querySelector('button[onclick="changeView(\'grid\')"]');
            const listBtn = document.querySelector('button[onclick="changeView(\'list\')"]');

            if (view === 'grid') {
                gridView.style.display = 'block';
                listView.style.display = 'none';
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
            } else {
                gridView.style.display = 'none';
                listView.style.display = 'block';
                gridBtn.classList.remove('active');
                listBtn.classList.add('active');
            }
        };

        // Advanced filter toggle
        const advancedOptions = document.getElementById('advancedOptions');
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'btn btn-link btn-sm p-0 mt-2';
        toggleBtn.innerHTML = '<i class="fas fa-caret-down me-1"></i>Advanced Options';
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (advancedOptions.style.display === 'none') {
                advancedOptions.style.display = 'block';
                this.innerHTML = '<i class="fas fa-caret-up me-1"></i>Hide Options';
            } else {
                advancedOptions.style.display = 'none';
                this.innerHTML = '<i class="fas fa-caret-down me-1"></i>Advanced Options';
            }
        });

        document.querySelector('#advancedFilterForm .row').appendChild(toggleBtn);

        // Initialize calendar
        const calendarEl = document.getElementById('calendarView');
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                events: '{{ route("api.events.calendar") }}',
                eventClick: function(info) {
                    window.location.href = '/guest/events/' + info.event.extendedProps.slug;
                },
                eventDisplay: 'block',
                eventColor: '#198754',
                eventTextColor: '#ffffff'
            });
            calendar.render();
        }

        // Auto-submit form on filter change
        const filterForm = document.getElementById('advancedFilterForm');
        const filterSelects = filterForm.querySelectorAll('select');
        
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                filterForm.submit();
            });
        });

        // Report event function
        window.reportEvent = function(eventId) {
            const reason = prompt('Please enter the reason for reporting this event:');
            if (reason) {
                fetch('/api/events/' + eventId + '/report', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ reason: reason })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || 'Thank you for your report. We will review it shortly.');
                })
                .catch(error => {
                    alert('An error occurred while reporting the event.');
                });
            }
        };
    });
</script>
@endpush