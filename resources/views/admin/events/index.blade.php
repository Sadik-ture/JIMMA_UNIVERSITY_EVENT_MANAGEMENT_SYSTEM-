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
            <div class="stat-card stat-card-primary">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-number">{{ $totalCount }}</div>
                <div class="stat-label">Total Events</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $upcomingCount }}</div>
                <div class="stat-label">Upcoming</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-info">
                <div class="stat-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="stat-number">{{ $ongoingCount }}</div>
                <div class="stat-label">Ongoing</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card stat-card-warning">
                <div class="stat-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="stat-number">{{ $completedCount }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="ju-card mb-4">
        <div class="ju-card-header">
            <h5 class="ju-card-title">
                <i class="fas fa-filter me-2"></i>Filter Events
            </h5>
        </div>
        <div class="ju-card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label-ju">Search</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control form-control-ju" 
                                   id="searchInput" 
                                   placeholder="Search events..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="form-label-ju">Status</label>
                        <select class="form-select form-control-ju" id="statusFilter">
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
                        <label class="form-label-ju">Type</label>
                        <select class="form-select form-control-ju" id="typeFilter">
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
                        <label class="form-label-ju">Campus</label>
                        <select class="form-select form-control-ju" id="campusFilter">
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
                        <label class="form-label-ju">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-ju w-100" id="applyFilters">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-ju-outline">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Events Table Card -->
    <div class="ju-card">
        <div class="ju-card-header d-flex justify-content-between align-items-center">
            <h5 class="ju-card-title">
                <i class="fas fa-calendar me-2"></i>All Events
            </h5>
            <div>
                <a href="{{ route('admin.events.export') }}" class="btn btn-ju-outline me-2">
                    <i class="fas fa-download me-2"></i>Export
                </a>
                <a href="{{ route('admin.events.create') }}" class="btn btn-ju">
                    <i class="fas fa-plus me-2"></i>Create Event
                </a>
            </div>
        </div>
        <div class="ju-card-body">
            @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-ju" id="eventsTable">
                    <thead>
                        <tr>
                            <th>Event Details</th>
                            <th>Type & Organizer</th>
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
                                        <img src="{{ asset('storage/' . $event->image) }}" 
                                             alt="{{ $event->title }}"
                                             class="rounded"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    </div>
                                    @else
                                    <div class="flex-shrink-0 me-3">
                                        <div class="ju-avatar ju-avatar-lg" style="background: var(--ju-gradient-{{ $event->event_type_color }})">
                                            <i class="fas fa-{{ $event->event_type_icon }}"></i>
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
                                    <span class="ju-badge ju-badge-{{ $event->event_type_color }}">
                                        {{ ucfirst($event->event_type) }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="fas fa-user-tie me-1"></i>
                                    {{ $event->organizer }}
                                </small>
                            </td>
                            <td>
                                <div class="small">
                                    <div class="mb-1">
                                        <i class="fas fa-play text-success me-1"></i>
                                        <strong>Start:</strong>
                                        {{ $event->start_date->format('M d, Y h:i A') }}
                                    </div>
                                    <div>
                                        <i class="fas fa-stop text-danger me-1"></i>
                                        <strong>End:</strong>
                                        {{ $event->end_date->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small">
                                    @if($event->campus_name != 'Not specified')
                                    <div class="mb-1">
                                        <i class="fas fa-university me-1"></i>
                                        {{ $event->campus_name }}
                                    </div>
                                    @endif
                                    
                                    @if($event->building_name != 'Not specified')
                                    <div class="mb-1">
                                        <i class="fas fa-building me-1"></i>
                                        {{ $event->building_name }}
                                    </div>
                                    @endif
                                    
                                    @if($event->venue_name != 'Not specified')
                                    <div class="mb-1">
                                        <i class="fas fa-door-open me-1"></i>
                                        {{ $event->venue_name }}
                                    </div>
                                    @endif
                                    
                                    @if($event->campus_name == 'Not specified' && $event->building_name == 'Not specified' && $event->venue_name == 'Not specified')
                                    <span class="text-muted">Location not specified</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $now = now();
                                    if ($now < $event->start_date) {
                                        $status = 'upcoming';
                                        $badge = 'primary';
                                        $icon = 'clock';
                                    } elseif ($now >= $event->start_date && $now <= $event->end_date) {
                                        $status = 'ongoing';
                                        $badge = 'success';
                                        $icon = 'play-circle';
                                    } else {
                                        $status = 'completed';
                                        $badge = 'secondary';
                                        $icon = 'check-circle';
                                    }
                                @endphp
                                <div class="d-flex align-items-center gap-2">
                                    <span class="ju-badge ju-badge-{{ $badge }}">
                                        <i class="fas fa-{{ $icon }} me-1"></i>
                                        {{ ucfirst($status) }}
                                    </span>
                                    @if($event->is_featured)
                                    <span class="ju-badge ju-badge-warning" title="Featured Event">
                                        <i class="fas fa-star"></i>
                                    </span>
                                    @endif
                                    @if(!$event->is_public)
                                    <span class="ju-badge ju-badge-dark" title="Private Event">
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
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" 
                                       class="btn btn-outline-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Event">
                                        <i class="fas fa-edit"></i>
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
                    <i class="fas fa-calendar-times fa-4x text-muted"></i>
                </div>
                <h4 class="text-muted">No Events Found</h4>
                <p class="text-muted mb-4">Get started by creating your first event</p>
                <a href="{{ route('admin.events.create') }}" class="btn btn-ju">
                    <i class="fas fa-plus me-2"></i>Create Event
                </a>
            </div>
            @endif
        </div>
        
        @if($events->hasPages() && !request()->has('search'))
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
    .ju-badge {
        padding: 0.35rem 0.75rem;
        border-radius: var(--ju-radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .ju-badge-primary {
        background: var(--ju-gradient-primary);
        color: white;
    }
    
    .ju-badge-success {
        background: var(--ju-gradient-success);
        color: white;
    }
    
    .ju-badge-info {
        background: var(--ju-gradient-info);
        color: white;
    }
    
    .ju-badge-warning {
        background: var(--ju-gradient-warning);
        color: white;
    }
    
    .ju-badge-secondary {
        background: var(--ju-gradient-dark);
        color: white;
    }
    
    .ju-badge-dark {
        background: var(--ju-gray-700);
        color: white;
    }
    
    .form-label-ju {
        font-weight: 500;
        color: var(--ju-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .table-ju tbody tr {
        transition: all 0.3s ease;
    }
    
    .table-ju tbody tr:hover {
        background-color: rgba(var(--ju-primary-rgb), 0.05);
    }
    
    /* DataTables Custom Styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 1rem;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we need DataTables (only when not using server-side pagination)
        const hasSearchParams = window.location.search.includes('search=') || 
                               window.location.search.includes('status=') ||
                               window.location.search.includes('event_type=') ||
                               window.location.search.includes('campus_id=');
        
        const eventsTable = document.getElementById('eventsTable');
        
        if (eventsTable && !hasSearchParams) {
            // Initialize DataTable only when not using server-side filters
            $('#eventsTable').DataTable({
                "pageLength": 25,
                "responsive": true,
                "order": [[2, 'asc']], // Default sort by date (3rd column)
                "language": {
                    "search": "<i class='fas fa-search me-2'></i>Search:",
                    "lengthMenu": "<i class='fas fa-list me-2'></i>Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries available",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "first": "<i class='fas fa-angle-double-left'></i>",
                        "last": "<i class='fas fa-angle-double-right'></i>",
                        "next": "<i class='fas fa-angle-right'></i>",
                        "previous": "<i class='fas fa-angle-left'></i>"
                    }
                },
                "columnDefs": [
                    {
                        "targets": [5], // Actions column
                        "orderable": false,
                        "searchable": false
                    }
                ]
            });
        }
        
        // Filter functionality
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const typeFilter = document.getElementById('typeFilter');
        const campusFilter = document.getElementById('campusFilter');
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
            
            window.location.href = '{{ route("admin.events.index") }}?' + params.toString();
        });
        
        // Enter key to search
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
        
        // Auto-refresh page every 5 minutes to update event statuses (only if not using DataTables)
        if (!hasSearchParams) {
            setTimeout(function() {
                window.location.reload();
            }, 300000); // 5 minutes
        }
    });
</script>
@endpush