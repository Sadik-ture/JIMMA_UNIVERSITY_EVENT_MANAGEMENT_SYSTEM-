@extends('layouts.app')

@section('title', 'Events - JU Event Management')
@section('page-title', 'Events')
@section('page-subtitle', 'Browse all university events')

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Events</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3">
        <!-- Filters Card -->
        <div class="ju-card mb-4">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0"><i class="fas fa-filter me-2"></i>Filters</h5>
            </div>
            <div class="ju-card-body">
                <form method="GET" action="{{ route('events.guest.index') }}" id="filterForm">
                    <!-- Search -->
                    <div class="mb-3">
                        <label class="form-label">Search</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Search events...">
                        </div>
                    </div>
                    
                    <!-- Date Filter -->
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <select class="form-select" name="date">
                            <option value="">All Dates</option>
                            <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="upcoming" {{ request('date') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="past" {{ request('date') == 'past' ? 'selected' : '' }}>Past Events</option>
                        </select>
                    </div>
                    
                    <!-- Campus Filter -->
                    <div class="mb-3">
                        <label class="form-label">Campus</label>
                        <select class="form-select" name="campus">
                            <option value="">All Campuses</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus }}" {{ request('campus') == $campus ? 'selected' : '' }}>
                                    {{ $campus }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Venue Filter -->
                    <div class="mb-3">
                        <label class="form-label">Venue</label>
                        <select class="form-select" name="venue">
                            <option value="">All Venues</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue }}" {{ request('venue') == $venue ? 'selected' : '' }}>
                                    {{ $venue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Event Type Filter -->
                    <div class="mb-3">
                        <label class="form-label">Event Type</label>
                        <select class="form-select" name="event_type">
                            <option value="">All Types</option>
                            @foreach($eventTypes as $type)
                                <option value="{{ $type }}" {{ request('event_type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Sort Options -->
                    <div class="mb-3">
                        <label class="form-label">Sort By</label>
                        <select class="form-select" name="sort">
                            <option value="start_date" {{ request('sort') == 'start_date' ? 'selected' : '' }}>Date</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Recently Added</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <select class="form-select" name="order">
                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-ju">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                        <a href="{{ route('events.guest.index') }}" class="btn btn-ju-outline">
                            <i class="fas fa-times me-2"></i>Clear Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="ju-card">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0"><i class="fas fa-chart-pie me-2"></i>Event Types</h5>
            </div>
            <div class="ju-card-body">
                @php
                    $typeCounts = [];
                    foreach($eventTypes as $type) {
                        $typeCounts[$type] = \App\Models\Event::where('event_type', $type)->where('is_public', true)->count();
                    }
                @endphp
                
                @foreach($typeCounts as $type => $count)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ ucfirst($type) }}</span>
                    <span class="badge bg-secondary">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-lg-9">
        <!-- Events Header -->
        <div class="ju-card mb-4">
            <div class="ju-card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="ju-card-title mb-0"><i class="fas fa-calendar me-2"></i>All Events</h5>
                    <p class="text-muted mb-0 small">Showing {{ $events->firstItem() }} - {{ $events->lastItem() }} of {{ $events->total() }} events</p>
                </div>
                
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-ju-outline dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-plus me-2"></i>Calendar</a></li>
                        </ul>
                    </div>
                    
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary active" onclick="changeView('grid')">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="changeView('list')">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Events Grid/List -->
        <div id="events-grid-view">
            @if($events->count() > 0)
            <div class="row">
                @foreach($events as $event)
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="position-relative">
                            @if($event->featured_image)
                            <img src="{{ asset('storage/' . $event->featured_image) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 180px; object-fit: cover;">
                            @else
                            <div class="card-img-top bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="fas fa-{{ $event->event_type == 'sports' ? 'futbol' : ($event->event_type == 'cultural' ? 'music' : ($event->event_type == 'academic' ? 'graduation-cap' : 'calendar-day')) }} fa-3x text-success opacity-50"></i>
                            </div>
                            @endif
                            
                            <span class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-{{ $event->type_color }}">{{ ucfirst($event->event_type) }}</span>
                            </span>
                            
                            @if($event->status == 'ongoing')
                            <span class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning pulse-animation">
                                    <i class="fas fa-play-circle me-1"></i>Live
                                </span>
                            </span>
                            @endif
                            
                            @if($event->is_featured)
                            <span class="position-absolute bottom-0 start-0 m-3">
                                <span class="badge bg-warning">
                                    <i class="fas fa-star me-1"></i>Featured
                                </span>
                            </span>
                            @endif
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($event->description, 80) }}</p>
                            
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar text-success me-2"></i>
                                <small>{{ $event->start_date->format('M d, Y h:i A') }}</small>
                            </div>
                            
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt text-success me-2"></i>
                                <small>{{ $event->venue }}, {{ $event->campus }}</small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        {{ $event->registered_attendees }} attending
                                        @if($event->max_attendees)
                                        / {{ $event->max_attendees }} max
                                        @endif
                                    </small>
                                </div>
                                <span class="badge bg-{{ $event->status == 'upcoming' ? 'info' : ($event->status == 'ongoing' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('events.guest.show', $event->slug) }}" class="btn btn-sm btn-ju">
                                    <i class="fas fa-eye me-1"></i>Details
                                </a>
                                
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('events.share', $event->slug) }}?platform=facebook" target="_blank">
                                            <i class="fab fa-facebook me-2"></i>Facebook
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('events.share', $event->slug) }}?platform=twitter" target="_blank">
                                            <i class="fab fa-twitter me-2"></i>Twitter
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('events.share', $event->slug) }}?platform=whatsapp" target="_blank">
                                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                        </a></li>
                                        <li><a class="dropdown-item" href="{{ route('events.export.ics', $event->slug) }}">
                                            <i class="fas fa-calendar-plus me-2"></i>Add to Calendar
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h4>No Events Found</h4>
                <p class="text-muted">Try adjusting your filters or check back later for new events.</p>
                <a href="{{ route('events.guest.index') }}" class="btn btn-ju">
                    <i class="fas fa-times me-2"></i>Clear Filters
                </a>
            </div>
            @endif
            
            <!-- Pagination -->
            @if($events->hasPages())
            <div class="row mt-4">
                <div class="col-md-12">
                    <nav aria-label="Page navigation">
                        {{ $events->withQueryString()->links() }}
                    </nav>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Events List View (Hidden by default) -->
        <div id="events-list-view" style="display: none;">
            @if($events->count() > 0)
            <div class="list-group">
                @foreach($events as $event)
                <div class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="text-center">
                                <div class="bg-success bg-opacity-10 rounded p-3">
                                    <div class="text-success fw-bold">{{ $event->start_date->format('M') }}</div>
                                    <div class="fs-4 fw-bold">{{ $event->start_date->format('d') }}</div>
                                    <div class="text-muted small">{{ $event->start_date->format('Y') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
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
                        
                        <div class="col-md-4">
                            <div class="text-end">
                                <div class="mb-2">
                                    <small><i class="fas fa-clock text-success me-1"></i> {{ $event->start_date->format('h:i A') }}</small>
                                </div>
                                <div class="mb-2">
                                    <small><i class="fas fa-map-marker-alt text-success me-1"></i> {{ $event->venue }}</small>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('events.guest.show', $event->slug) }}" class="btn btn-sm btn-ju">
                                        Details
                                    </a>
                                    <a href="{{ route('events.share', $event->slug) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-share-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($events->hasPages())
            <div class="row mt-4">
                <div class="col-md-12">
                    <nav aria-label="Page navigation">
                        {{ $events->withQueryString()->links() }}
                    </nav>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-shadow {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View toggle
        window.changeView = function(view) {
            const gridView = document.getElementById('events-grid-view');
            const listView = document.getElementById('events-list-view');
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
        
        // Auto-submit form on filter change
        const filterForm = document.getElementById('filterForm');
        const filterInputs = filterForm.querySelectorAll('select, input[type="text"]');
        
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                filterForm.submit();
            });
        });
        
        // Initialize view
        changeView('grid');
    });
</script>
@endpush