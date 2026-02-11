@extends('layouts.app')

@section('title', 'My Event Requests - JU Event Management')
@section('page-title', 'My Event Requests')
@section('page-subtitle', 'Track and manage your event requests')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="{{ route('event-requests.my-requests') }}" 
                       class="btn btn-{{ !request()->has('status') ? 'primary' : 'outline-primary' }}">
                        All
                    </a>
                    <a href="{{ route('event-requests.my-requests', ['status' => 'pending']) }}" 
                       class="btn btn-{{ request('status') == 'pending' ? 'warning' : 'outline-warning' }}">
                        Pending
                    </a>
                    <a href="{{ route('event-requests.my-requests', ['status' => 'approved']) }}" 
                       class="btn btn-{{ request('status') == 'approved' ? 'success' : 'outline-success' }}">
                        Approved
                    </a>
                    <a href="{{ route('event-requests.my-requests', ['status' => 'rejected']) }}" 
                       class="btn btn-{{ request('status') == 'rejected' ? 'danger' : 'outline-danger' }}">
                        Rejected
                    </a>
                    <a href="{{ route('event-requests.my-requests', ['status' => 'cancelled']) }}" 
                       class="btn btn-{{ request('status') == 'cancelled' ? 'secondary' : 'outline-secondary' }}">
                        Cancelled
                    </a>
                </div>
                <a href="{{ route('event-requests.create') }}" class="btn btn-ju-primary">
                    <i class="fas fa-plus-circle me-1"></i> New Event Request
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card stat-card-primary">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-number">{{ $totalCount }}</div>
                <div class="stat-label">Total Requests</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card stat-card-warning">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $pendingCount }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">{{ $approvedCount }}</div>
                <div class="stat-label">Approved</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card stat-card-danger">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-number">{{ $rejectedCount }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card ju-card">
                <div class="card-body">
                    <form method="GET" action="{{ route('event-requests.my-requests') }}" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control ju-input" 
                                       name="search" placeholder="Search by event title, description..." 
                                       value="{{ request('search') }}">
                                <button class="btn btn-ju-primary" type="submit">
                                    <i class="fas fa-search me-1"></i> Search
                                </button>
                                @if(request()->hasAny(['search', 'status']))
                                <a href="{{ route('event-requests.my-requests') }}" class="btn btn-ju-outline">
                                    <i class="fas fa-times me-1"></i> Clear
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="sort" class="form-select" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    <i class="fas fa-sort-amount-down me-1"></i> Latest First
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    <i class="fas fa-sort-amount-up me-1"></i> Oldest First
                                </option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>
                                    <i class="fas fa-sort-alpha-down me-1"></i> Title A-Z
                                </option>
                                <option value="title-desc" {{ request('sort') == 'title-desc' ? 'selected' : '' }}>
                                    <i class="fas fa-sort-alpha-up me-1"></i> Title Z-A
                                </option>
                                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>
                                    <i class="fas fa-calendar-alt me-1"></i> Proposed Date
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests List -->
    <div class="row">
        <div class="col-12">
            <div class="card ju-card">
                <div class="card-header ju-card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        My Event Requests
                    </h5>
                    <span class="badge bg-primary">{{ $eventRequests->total() }} Total</span>
                </div>
                <div class="card-body p-0">
                    @if($eventRequests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover ju-table mb-0">
                            <thead>
                                <tr>
                                    <th>Event Title</th>
                                    <th>Proposed Date</th>
                                    <th>Venue</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventRequests as $request)
                                <tr>
                                    <td>
                                        <strong>{{ $request->title }}</strong><br>
                                        <small class="text-muted">
                                            <i class="fas fa-tag me-1"></i>{{ ucfirst($request->event_type) }}
                                        </small>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-primary me-1"></i>
                                        {{ $request->proposed_start_date->format('M d, Y') }}<br>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $request->proposed_start_date->format('h:i A') }} - 
                                            {{ $request->proposed_end_date->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        {{ Str::limit($request->proposed_venue, 30) }}<br>
                                        <small class="text-muted">{{ $request->proposed_campus ?? 'Campus TBD' }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'rejected' => 'danger',
                                                'cancelled' => 'secondary'
                                            ];
                                            $statusIcons = [
                                                'pending' => 'clock',
                                                'approved' => 'check-circle',
                                                'rejected' => 'times-circle',
                                                'cancelled' => 'ban'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$request->status] ?? 'secondary' }} px-3 py-2">
                                            <i class="fas fa-{{ $statusIcons[$request->status] ?? 'circle' }} me-1"></i>
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        @if($request->reviewed_by)
                                        <br>
                                        <small class="text-muted">
                                            Reviewed by: {{ $request->reviewer->name ?? 'Admin' }}
                                        </small>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fas fa-clock text-muted me-1"></i>
                                        {{ $request->created_at->diffForHumans() }}<br>
                                        <small class="text-muted">
                                            {{ $request->created_at->format('M d, Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- View Button -->
                                            <a href="{{ route('event-requests.show', $request) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="View Details"
                                               data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($request->status === 'pending')
                                                <!-- Edit Button -->
                                                @if(Auth::id() === $request->user_id)
                                                    <a href="{{ route('event-requests.edit', $request) }}" 
                                                       class="btn btn-sm btn-warning"
                                                       title="Edit Request"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <!-- Cancel Button -->
                                                    <button type="button" 
                                                            class="btn btn-sm btn-secondary"
                                                            title="Cancel Request"
                                                            data-bs-toggle="tooltip"
                                                            onclick="confirmCancelRequest({{ $request->id }}, '{{ $request->title }}')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            @endif
                                            
                                            @if($request->status === 'approved' && $request->event_id)
                                                <!-- View Event Button -->
                                                <a href="{{ route('admin.events.show', $request->event_id) }}" 
                                                   class="btn btn-sm btn-success"
                                                   title="View Created Event"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fas fa-calendar-check"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $eventRequests->firstItem() ?? 0 }} to {{ $eventRequests->lastItem() ?? 0 }} 
                                of {{ $eventRequests->total() }} requests
                            </div>
                            <div>
                                {{ $eventRequests->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <div class="mb-4">
                                <i class="fas fa-calendar-times fa-4x text-muted"></i>
                            </div>
                            <h4 class="mb-3">No Event Requests Found</h4>
                            <p class="text-muted mb-4">
                                @if(request()->hasAny(['search', 'status']))
                                    No requests match your current filters.
                                    <br>
                                    <a href="{{ route('event-requests.my-requests') }}" class="btn btn-link">
                                        Clear all filters
                                    </a>
                                @else
                                    You haven't submitted any event requests yet.
                                @endif
                            </p>
                            @if(!request()->hasAny(['search', 'status']))
                                <a href="{{ route('event-requests.create') }}" class="btn btn-ju-primary btn-lg">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Create Your First Event Request
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats & Info -->
    @if($eventRequests->count() > 0)
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card ju-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Request Status Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="progress mb-3" style="height: 25px;">
                        @if($totalCount > 0)
                        <div class="progress-bar bg-warning" 
                             style="width: {{ ($pendingCount / $totalCount) * 100 }}%"
                             role="progressbar">
                            Pending {{ $pendingCount }}
                        </div>
                        <div class="progress-bar bg-success" 
                             style="width: {{ ($approvedCount / $totalCount) * 100 }}%"
                             role="progressbar">
                            Approved {{ $approvedCount }}
                        </div>
                        <div class="progress-bar bg-danger" 
                             style="width: {{ ($rejectedCount / $totalCount) * 100 }}%"
                             role="progressbar">
                            Rejected {{ $rejectedCount }}
                        </div>
                        <div class="progress-bar bg-secondary" 
                             style="width: {{ ($cancelledCount / $totalCount) * 100 }}%"
                             role="progressbar">
                            Cancelled {{ $cancelledCount }}
                        </div>
                        @endif
                    </div>
                    <div class="row text-center mt-4">
                        <div class="col-3">
                            <span class="badge bg-warning p-2 w-100">
                                Approval Rate: 
                                @if($totalCount > 0)
                                    {{ round(($approvedCount / $totalCount) * 100) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                        <div class="col-3">
                            <span class="badge bg-info p-2 w-100">
                                Avg. Response: 2-3 days
                            </span>
                        </div>
                        <div class="col-6">
                            <span class="badge bg-primary p-2 w-100">
                                <i class="fas fa-clock me-1"></i>
                                Last Request: {{ $eventRequests->first()?->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card ju-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        Tips for Successful Requests
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Provide detailed event descriptions
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Select venues with sufficient capacity
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Submit requests at least 1 week in advance
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Include all technical requirements
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Ensure contact information is accurate
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Cancel Request Modal -->
<div class="modal fade" id="cancelRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cancel Event Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="cancelRequestForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to cancel this event request?</p>
                    <div class="alert alert-warning">
                        <strong id="cancelRequestTitle">Loading...</strong>
                    </div>
                    <div class="mb-3">
                        <label for="cancellation_reason" class="form-label">Reason for Cancellation (Optional)</label>
                        <textarea class="form-control" id="cancellation_reason" 
                                  name="cancellation_reason" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-ban me-1"></i> Yes, Cancel Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.stat-card {
    transition: all 0.3s ease;
    border: none;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.empty-state {
    padding: 40px 20px;
}
.btn-group .btn {
    margin: 0 2px;
}
.ju-table td {
    vertical-align: middle;
}
.progress-bar {
    font-size: 0.75rem;
    font-weight: 600;
    line-height: 25px;
}
</style>
@endpush

@push('scripts')
<script>
function confirmCancelRequest(requestId, requestTitle) {
    const form = document.getElementById('cancelRequestForm');
    form.action = `/event-requests/${requestId}/cancel`;
    document.getElementById('cancelRequestTitle').textContent = requestTitle;
    
    const modal = new bootstrap.Modal(document.getElementById('cancelRequestModal'));
    modal.show();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(function() {
            alert.remove();
        }, 500);
    });
}, 5000);
</script>
@endpush