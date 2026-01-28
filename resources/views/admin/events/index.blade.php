@extends('layouts.app')

@section('title', 'Events Management - Jimma University')

@section('page-title', 'Admin Events Management')
@section('page-subtitle', 'Manage all university events')

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Admin Events</li>
@endsection

@section('content')
<div class="ju-card">
    <div class="ju-card-header d-flex justify-content-between align-items-center">
        <h5 class="ju-card-title mb-0">Events List</h5>
        <div>
            <a href="{{ route('admin.events.create') }}" class="btn btn-ju">
                <i class="fas fa-plus me-2"></i> Add New Event
            </a>
        </div>
    </div>
    
    <div class="ju-card-body">
        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search events..." 
                           id="searchInput" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Past</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="typeFilter">
                    <option value="">All Types</option>
                    <option value="academic" {{ request('event_type') == 'academic' ? 'selected' : '' }}>Academic</option>
                    <option value="cultural" {{ request('event_type') == 'cultural' ? 'selected' : '' }}>Cultural</option>
                    <option value="sports" {{ request('event_type') == 'sports' ? 'selected' : '' }}>Sports</option>
                    <option value="conference" {{ request('event_type') == 'conference' ? 'selected' : '' }}>Conference</option>
                    <option value="workshop" {{ request('event_type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="seminar" {{ request('event_type') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="campusFilter">
                    <option value="">All Campuses</option>
                    <option value="main" {{ request('campus') == 'main' ? 'selected' : '' }}>Main Campus</option>
                    <option value="technology" {{ request('campus') == 'technology' ? 'selected' : '' }}>Technology Campus</option>
                    <option value="medical" {{ request('campus') == 'medical' ? 'selected' : '' }}>Medical Campus</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-ju" id="applyFilters">
                    <i class="fas fa-filter me-2"></i> Apply
                </button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-2"></i> Reset
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="ju-card">
                    <div class="ju-card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: rgba(0, 100, 0, 0.1); color: var(--ju-green);">
                                <i class="fas fa-calendar-alt fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">{{ $totalCount }}</h3>
                                <p class="text-muted mb-0">Total Events</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ju-card">
                    <div class="ju-card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">{{ $upcomingCount }}</h3>
                                <p class="text-muted mb-0">Upcoming</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ju-card">
                    <div class="ju-card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: rgba(25, 135, 84, 0.1); color: #198754;">
                                <i class="fas fa-play-circle fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">{{ $ongoingCount }}</h3>
                                <p class="text-muted mb-0">Ongoing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ju-card">
                    <div class="ju-card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: rgba(108, 117, 125, 0.1); color: #6c757d;">
                                <i class="fas fa-history fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">{{ $completedCount }}</h3>
                                <p class="text-muted mb-0">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Table -->
        <div class="table-responsive">
            <table class="table table-ju table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Dates</th>
                        <th>Venue</th>
                        <th>Status</th>
                        <th>Visibility</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" 
                                     class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <div class="rounded me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: var(--ju-light-green); color: var(--ju-green);">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                @endif
                                <div>
                                    <strong>{{ $event->title }}</strong>
                                    <div class="text-muted small">{{ Str::limit($event->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($event->event_type) }}</span>
                        </td>
                        <td>
                            <small class="d-block"><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y h:i A') }}</small>
                            <small class="d-block"><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y h:i A') }}</small>
                        </td>
                        <td>
                            <div>{{ $event->venue }}</div>
                            <small class="text-muted">{{ $event->campus ?: 'N/A' }}</small>
                        </td>
                        <td>
                            @php
                                $now = now();
                                $start = \Carbon\Carbon::parse($event->start_date);
                                $end = \Carbon\Carbon::parse($event->end_date);
                                
                                if ($now < $start) {
                                    $status = 'upcoming';
                                    $badgeClass = 'bg-primary';
                                } elseif ($now >= $start && $now <= $end) {
                                    $status = 'ongoing';
                                    $badgeClass = 'bg-success';
                                } else {
                                    $status = 'completed';
                                    $badgeClass = 'bg-secondary';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $event->is_public ? 'bg-success' : 'bg-warning' }}">
                                {{ $event->is_public ? 'Public' : 'Private' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.events.show', $event) }}" class="btn btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete" 
                                            onclick="return confirm('Are you sure you want to delete this event?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                <h5>No events found</h5>
                                <p>Start by adding your first event</p>
                                <a href="{{ route('admin.events.create') }}" class="btn btn-ju mt-2">
                                    <i class="fas fa-plus me-2"></i> Add Event
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} entries
            </div>
            <div>
                {{ $events->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                params.set('campus', campusFilter.value);
            }
            
            window.location.href = '{{ route("admin.events.index") }}?' + params.toString();
        });
        
        // Enter key to search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters.click();
            }
        });
    });
</script>
@endpush