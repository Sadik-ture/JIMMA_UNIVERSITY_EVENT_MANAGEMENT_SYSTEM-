@extends('layouts.app')

@section('title', $speaker->name . ' - Jimma University')

@section('page-title', $speaker->name)
@section('page-subtitle', 'Speaker Details')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('speakers.index') }}">Speakers</a></li>
    <li class="breadcrumb-item active">{{ $speaker->name }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="ju-card mb-4">
            <div class="ju-card-header d-flex justify-content-between align-items-center">
                <h5 class="ju-card-title mb-0">Speaker Information</h5>
                <div class="btn-group">
                    <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this speaker?')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="ju-card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($speaker->photo)
                        <img src="{{ asset('storage/' . $speaker->photo) }}" alt="{{ $speaker->name }}" 
                             class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 mx-auto" 
                             style="width: 200px; height: 200px; background: var(--ju-light-green); color: var(--ju-green);">
                            <i class="fas fa-user fa-5x"></i>
                        </div>
                        @endif
                        
                        <h4>{{ $speaker->name }}</h4>
                        <p class="text-muted">{{ $speaker->title }}</p>
                        
                        <div class="mb-3">
                            @if($speaker->is_active)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-secondary">Inactive</span>
                            @endif
                            
                            @if($speaker->is_featured)
                            <span class="badge bg-warning ms-1">Featured</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h5>Biography</h5>
                            <p>{{ $speaker->bio }}</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6><i class="fas fa-building text-primary me-2"></i> Department</h6>
                                    <p class="ms-4">{{ $speaker->department }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6><i class="fas fa-graduation-cap text-success me-2"></i> Expertise</h6>
                                    <p class="ms-4">{{ $speaker->expertise ?: 'Not specified' }}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6><i class="fas fa-envelope text-danger me-2"></i> Contact</h6>
                                    <div class="ms-4">
                                        <div><strong>Email:</strong> <a href="mailto:{{ $speaker->email }}">{{ $speaker->email }}</a></div>
                                        @if($speaker->phone)
                                        <div><strong>Phone:</strong> <a href="tel:{{ $speaker->phone }}">{{ $speaker->phone }}</a></div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <h6><i class="fas fa-link text-info me-2"></i> Links</h6>
                                    <div class="ms-4">
                                        @if($speaker->website)
                                        <div><strong>Website:</strong> <a href="{{ $speaker->website }}" target="_blank">{{ $speaker->website }}</a></div>
                                        @endif
                                        @if($speaker->linkedin)
                                        <div><strong>LinkedIn:</strong> <a href="{{ $speaker->linkedin }}" target="_blank">View Profile</a></div>
                                        @endif
                                        @if($speaker->twitter)
                                        <div><strong>Twitter/X:</strong> <a href="{{ $speaker->twitter }}" target="_blank">View Profile</a></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Speaker's Events -->
        <div class="ju-card">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0">Speaker's Events</h5>
            </div>
            <div class="ju-card-body">
                @if($speaker->events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-ju table-hover">
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Date</th>
                                <th>Venue</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($speaker->events as $event)
                            <tr>
                                <td>
                                    <a href="{{ route('events.show', $event) }}">{{ $event->title }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</td>
                                <td>{{ $event->venue }}</td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($event->event_type) }}</span>
                                </td>
                                <td>
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5>No events assigned</h5>
                    <p class="text-muted">This speaker has not been assigned to any events yet.</p>
                   <a href="{{ route('admin.events.create') }}" class="btn btn-ju mt-2">        
                        <i class="fas fa-plus me-2"></i> Create Event
                    </a>
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
                    <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i> Edit Speaker
                    </a>
                    
                    <form action="{{ route('speakers.toggle-active', $speaker) }}" method="POST" class="d-grid">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn {{ $speaker->is_active ? 'btn-secondary' : 'btn-success' }}">
                            <i class="fas fa-user me-2"></i> 
                            {{ $speaker->is_active ? 'Deactivate Speaker' : 'Activate Speaker' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('speakers.toggle-featured', $speaker) }}" method="POST" class="d-grid">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn {{ $speaker->is_featured ? 'btn-secondary' : 'btn-outline-warning' }}">
                            <i class="fas fa-star me-2"></i> 
                            {{ $speaker->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('speakers.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        
        <div class="ju-card">
            <div class="ju-card-header">
                <h6 class="ju-card-title mb-0">Speaker Statistics</h6>
            </div>
            <div class="ju-card-body">
                <div class="mb-3">
                    <small class="text-muted">Total Events</small>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                        <h4 class="mb-0">{{ $speaker->events_count }}</h4>
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Created</small>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-plus text-muted me-2"></i>
                        {{ $speaker->created_at->format('M d, Y') }}
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Last Updated</small>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-history text-muted me-2"></i>
                        {{ $speaker->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection