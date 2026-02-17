{{-- resources/views/admin/events/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Events Management - Jimma University')
@section('page-title', 'Events Management')
@section('page-subtitle', 'Manage all university events and activities')

@section('breadcrumb-items')
    <li class="breadcrumb-item active">All Events</li>
@endsection

@section('content')
<div class="content-area">
    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #003366 0%, #004080 100%);">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt text-white"></i>
                </div>
                <div class="stat-number text-white">{{ $totalCount }}</div>
                <div class="stat-label text-white-50">Total Events</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #004d40 0%, #00695c 100%);">
                <div class="stat-icon">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div class="stat-number text-white">{{ $upcomingCount }}</div>
                <div class="stat-label text-white-50">Upcoming</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #0277bd 0%, #039be5 100%);">
                <div class="stat-icon">
                    <i class="fas fa-play-circle text-white"></i>
                </div>
                <div class="stat-number text-white">{{ $ongoingCount }}</div>
                <div class="stat-label text-white-50">Ongoing</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #b71c1c 0%, #d32f2f 100%);">
                <div class="stat-icon">
                    <i class="fas fa-history text-white"></i>
                </div>
                <div class="stat-number text-white">{{ $completedCount }}</div>
                <div class="stat-label text-white-50">Completed</div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="ju-card mb-4">
        <div class="ju-card-header" style="background: linear-gradient(135deg, #003366 0%, #004080 100%);">
            <h5 class="ju-card-title text-white mb-0">
                <i class="fas fa-filter me-2"></i>Filter Events
            </h5>
        </div>
        <div class="ju-card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label-ju" style="color: #003366;">Search</label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-color: #003366;">
                                <i class="fas fa-search" style="color: #003366;"></i>
                            </span>
                            <input type="text" 
                                   class="form-control form-control-ju" 
                                   id="searchInput" 
                                   placeholder="Search events..."
                                   value="{{ request('search') }}"
                                   style="border-color: #003366;">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="form-label-ju" style="color: #003366;">Status</label>
                        <select class="form-select form-control-ju" id="statusFilter" style="border-color: #003366;">
                            <option value="">All Status</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>
                                Upcoming
                            </option>
                            <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>
                                Ongoing
                            </option>
                            <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>
                                Completed
                            </option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="form-label-ju" style="color: #003366;">Type</label>
                        <select class="form-select form-control-ju" id="typeFilter" style="border-color: #003366;">
                            <option value="">All Types</option>
                            <option value="academic" {{ request('event_type') == 'academic' ? 'selected' : '' }}>
                                Academic
                            </option>
                            <option value="cultural" {{ request('event_type') == 'cultural' ? 'selected' : '' }}>
                                Cultural
                            </option>
                            <option value="sports" {{ request('event_type') == 'sports' ? 'selected' : '' }}>
                                Sports
                            </option>
                            <option value="conference" {{ request('event_type') == 'conference' ? 'selected' : '' }}>
                                Conference
                            </option>
                            <option value="workshop" {{ request('event_type') == 'workshop' ? 'selected' : '' }}>
                                Workshop
                            </option>
                            <option value="seminar" {{ request('event_type') == 'seminar' ? 'selected' : '' }}>
                                Seminar
                            </option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="form-label-ju" style="color: #003366;">Campus</label>
                        <select class="form-select form-control-ju" id="campusFilter" style="border-color: #003366;">
                            <option value="">All Campuses</option>
                            @foreach($campuses as $campus)
                            <option value="{{ $campus->id }}" {{ request('campus_id') == $campus->id ? 'selected' : '' }}>
                                {{ $campus->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label-ju" style="color: #003366;">Speaker</label>
                        <select class="form-select form-control-ju" id="speakerFilter" style="border-color: #003366;">
                            <option value="">All Speakers</option>
                            @foreach($speakers as $speaker)
                            <option value="{{ $speaker->id }}" {{ request('speaker_id') == $speaker->id ? 'selected' : '' }}>
                                {{ $speaker->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="d-flex gap-2 justify-content-end">
                        <button class="btn" style="background-color: #003366; color: white;" id="applyFilters">
                            <i class="fas fa-filter me-2"></i>Apply Filters
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary" style="border-color: #003366; color: #003366;">
                            <i class="fas fa-redo me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Events Table Card -->
    <div class="ju-card">
        <div class="ju-card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #003366 0%, #004080 100%);">
            <h5 class="ju-card-title text-white mb-0">
                <i class="fas fa-calendar me-2"></i>All Events
            </h5>
            <div>
                <a href="{{ route('admin.events.export') }}" class="btn btn-light me-2" style="color: #003366;">
                    <i class="fas fa-download me-2"></i>Export
                </a>
                <a href="{{ route('admin.events.create') }}" class="btn btn-light" style="color: #003366;">
                    <i class="fas fa-plus me-2"></i>Create Event
                </a>
            </div>
        </div>
        <div class="ju-card-body">
            @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-ju table-hover" id="eventsTable">
                    <thead>
                        <tr>
                            <th>Event Details</th>
                            <th>Type & Organizer</th>
                            <th>Speakers</th>
                            <th>Date & Time</th>
                            <th>Venue</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($event->image)
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ $event->image_url }}" 
                                             alt="{{ $event->title }}"
                                             class="rounded"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </div>
                                    @else
                                    <div class="flex-shrink-0 me-3">
                                        <div class="ju-avatar ju-avatar-lg" style="background: linear-gradient(135deg, #003366 0%, #004080 100%);">
                                            <i class="fas fa-{{ $event->event_type_icon }} text-white"></i>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $event->title }}</h6>
                                        <p class="text-muted small mb-0">{{ Str::limit($event->short_description ?: $event->description, 60) }}</p>
                                        <div class="mt-1">
                                            <small class="text-muted">
                                                <i class="fas fa-users me-1"></i>
                                                {{ $event->registered_attendees }} / {{ $event->max_attendees ?? '∞' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="mb-2">
                                    <span class="badge" style="background-color: #003366; color: white;">
                                        {{ ucfirst($event->event_type) }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-user-tie me-1"></i>
                                    {{ $event->organizer }}
                                </small>
                            </td>
                            <td>
                                @if($event->speakers->count() > 0)
                                    <div class="speaker-avatars">
                                        @foreach($event->speakers->take(3) as $speaker)
                                            @if($speaker->photo)
                                                <img src="{{ $speaker->photo_url }}" 
                                                     alt="{{ $speaker->name }}"
                                                     class="rounded-circle border border-2 border-white"
                                                     style="width: 30px; height: 30px; object-fit: cover; margin-left: -5px;"
                                                     data-bs-toggle="tooltip"
                                                     title="{{ $speaker->name }}">
                                            @else
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center border border-2 border-white"
                                                     style="width: 30px; height: 30px; background: linear-gradient(135deg, #003366 0%, #004080 100%); color: white; margin-left: -5px;"
                                                     data-bs-toggle="tooltip"
                                                     title="{{ $speaker->name }}">
                                                    <i class="fas fa-user fa-xs"></i>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if($event->speakers->count() > 3)
                                            <span class="ms-1 small text-muted">+{{ $event->speakers->count() - 3 }} more</span>
                                        @endif
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        {{ $event->keynoteSpeakers->count() }} keynote
                                    </small>
                                @else
                                    <span class="text-muted small">No speakers assigned</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div class="mb-1">
                                        <i class="fas fa-play text-success me-1"></i>
                                        {{ $event->start_date->format('M d, Y h:i A') }}
                                    </div>
                                    <div>
                                        <i class="fas fa-stop text-danger me-1"></i>
                                        {{ $event->end_date->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small">
                                    @if($event->campus_name != 'Not specified')
                                    <div class="mb-1">
                                        <i class="fas fa-university me-1" style="color: #003366;"></i>
                                        {{ $event->campus_name }}
                                    </div>
                                    @endif
                                    
                                    @if($event->building_name != 'Not specified')
                                    <div class="mb-1">
                                        <i class="fas fa-building me-1" style="color: #003366;"></i>
                                        {{ $event->building_name }}
                                    </div>
                                    @endif
                                    
                                    @if($event->venue_name != 'Not specified')
                                    <div>
                                        <i class="fas fa-door-open me-1" style="color: #003366;"></i>
                                        {{ $event->venue_name }}
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $status = $event->status;
                                    $badgeClass = $status == 'upcoming' ? 'bg-primary' : ($status == 'ongoing' ? 'bg-success' : 'bg-secondary');
                                    $icon = $status == 'upcoming' ? 'clock' : ($status == 'ongoing' ? 'play-circle' : 'check-circle');
                                @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge {{ $badgeClass }}" style="background-color: {{ $status == 'upcoming' ? '#003366' : ($status == 'ongoing' ? '#004d40' : '#6c757d') }};">
                                        <i class="fas fa-{{ $icon }} me-1"></i>
                                        {{ ucfirst($status) }}
                                    </span>
                                    @if($event->is_featured)
                                    <span class="badge bg-warning text-dark" title="Featured Event">
                                        <i class="fas fa-star"></i>
                                    </span>
                                    @endif
                                    @if(!$event->is_public)
                                    <span class="badge bg-dark" title="Private Event">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.events.show', $event) }}" 
                                       class="btn btn-outline-info" 
                                       data-bs-toggle="tooltip" 
                                       title="View Details"
                                       style="border-color: #003366; color: #003366;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" 
                                       class="btn btn-outline-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Event"
                                       style="border-color: #ffc107; color: #ffc107;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.events.speakers.manage', $event) }}" 
                                       class="btn btn-outline-success" 
                                       data-bs-toggle="tooltip" 
                                       title="Manage Speakers"
                                       style="border-color: #28a745; color: #28a745;">
                                        <i class="fas fa-users"></i>
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this event?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete Event">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-calendar-times fa-4x" style="color: #003366;"></i>
                </div>
                <h4 class="text-muted">No Events Found</h4>
                <p class="text-muted mb-4">Get started by creating your first event</p>
                <a href="{{ route('admin.events.create') }}" class="btn" style="background-color: #003366; color: white;">
                    <i class="fas fa-plus me-2"></i>Create Event
                </a>
            </div>
            @endif
        </div>
        
        @if($events->hasPages())
        <div class="ju-card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">
                        Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} entries
                    </small>
                </div>
                <div>
                    {{ $events->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        padding: 1.5rem;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card .stat-icon {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 2.5rem;
        opacity: 0.3;
    }
    
    .stat-card .stat-number {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .stat-card .stat-label {
        font-size: 0.875rem;
    }
    
    .ju-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .ju-card-header {
        padding: 1rem 1.5rem;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    
    .form-label-ju {
        font-weight: 500;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .speaker-avatars {
        display: flex;
        align-items: center;
    }
    
    .speaker-avatars img,
    .speaker-avatars div {
        transition: transform 0.2s;
    }
    
    .speaker-avatars img:hover,
    .speaker-avatars div:hover {
        transform: scale(1.1);
        z-index: 10;
    }
    
    .btn-group .btn:hover {
        transform: translateY(-2px);
        transition: transform 0.2s;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const typeFilter = document.getElementById('typeFilter');
        const campusFilter = document.getElementById('campusFilter');
        const speakerFilter = document.getElementById('speakerFilter');
        const applyFilters = document.getElementById('applyFilters');
        
        applyFilters.addEventListener('click', function() {
            const params = new URLSearchParams();
            
            if (searchInput.value) {
                params.set('search', searchInput.value);
            }
            
            if (statusFilter.value) {
                params.set('status', statusFilter.value);
            }
            
            if (typeFilter.value) {
                params.set('event_type', typeFilter.value);
            }
            
            if (campusFilter.value) {
                params.set('campus_id', campusFilter.value);
            }
            
            if (speakerFilter.value) {
                params.set('speaker_id', speakerFilter.value);
            }
            
            window.location.href = '{{ route("admin.events.index") }}?' + params.toString();
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters.click();
            }
        });
        
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush