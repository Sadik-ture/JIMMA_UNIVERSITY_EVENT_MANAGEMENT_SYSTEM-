@extends('layouts.app')

@section('title', 'Event Requests - JU Event Management')

@section('content')
<div class="container-fluid px-4">
    <div class="row my-4">
        <div class="col-12">
            <div class="card ju-card">
                <div class="card-header ju-card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>Event Requests
                        @if($pendingCount > 0)
                        <span class="badge bg-danger ms-2">{{ $pendingCount }} pending</span>
                        @endif
                    </h4>
                    <a href="{{ route('event-requests.create') }}" class="btn ju-btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> New Request
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filter Tabs -->
                    <ul class="nav nav-tabs ju-tabs mb-4" id="requestsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ !request()->has('status') ? 'active' : '' }}" 
                               href="{{ route('event-requests.index') }}">
                                All Requests
                                <span class="badge bg-secondary ms-1">{{ $totalCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" 
                               href="{{ route('event-requests.index', ['status' => 'pending']) }}">
                                Pending
                                <span class="badge bg-warning ms-1">{{ $pendingCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}" 
                               href="{{ route('event-requests.index', ['status' => 'approved']) }}">
                                Approved
                                <span class="badge bg-success ms-1">{{ $approvedCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" 
                               href="{{ route('event-requests.index', ['status' => 'rejected']) }}">
                                Rejected
                                <span class="badge bg-danger ms-1">{{ $rejectedCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" 
                               href="{{ route('event-requests.index', ['status' => 'cancelled']) }}">
                                Cancelled
                                <span class="badge bg-secondary ms-1">{{ $cancelledCount }}</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Search and Filter -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('event-requests.index') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control ju-input" name="search" 
                                           placeholder="Search by event title, organizer name..." 
                                           value="{{ request('search') }}">
                                    <button class="btn ju-btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    @if(request()->hasAny(['search', 'status', 'event_type']))
                                    <a href="{{ route('event-requests.index') }}" class="btn ju-btn-outline">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select ju-input" onchange="window.location.href = this.value">
                                <option value="{{ route('event-requests.index') }}?event_type=">All Event Types</option>
                                <option value="{{ route('event-requests.index') }}?event_type=academic" 
                                        {{ request('event_type') == 'academic' ? 'selected' : '' }}>
                                    Academic
                                </option>
                                <option value="{{ route('event-requests.index') }}?event_type=cultural" 
                                        {{ request('event_type') == 'cultural' ? 'selected' : '' }}>
                                    Cultural
                                </option>
                                <option value="{{ route('event-requests.index') }}?event_type=sports" 
                                        {{ request('event_type') == 'sports' ? 'selected' : '' }}>
                                    Sports
                                </option>
                                <option value="{{ route('event-requests.index') }}?event_type=conference" 
                                        {{ request('event_type') == 'conference' ? 'selected' : '' }}>
                                    Conference
                                </option>
                                <option value="{{ route('event-requests.index') }}?event_type=workshop" 
                                        {{ request('event_type') == 'workshop' ? 'selected' : '' }}>
                                    Workshop
                                </option>
                                <option value="{{ route('event-requests.index') }}?event_type=seminar" 
                                        {{ request('event_type') == 'seminar' ? 'selected' : '' }}>
                                    Seminar
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Requests Table -->
                    <div class="table-responsive">
                        <table class="table table-hover ju-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Event Title</th>
                                    <th>Organizer</th>
                                    <th>Type</th>
                                    <th>Proposed Date</th>
                                    <th>Venue</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">#{{ $request->id }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $request->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($request->description, 50) }}</small>
                                    </td>
                                    <td>
                                        {{ $request->organizer_name }}
                                        <br>
                                        <small class="text-muted">{{ $request->organizer_email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge ju-badge">{{ ucfirst($request->event_type) }}</span>
                                    </td>
                                    <td>
                                        {{ $request->proposed_start_date->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">to {{ $request->proposed_end_date->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        {{ $request->proposed_venue }}
                                        @if($request->proposed_campus)
                                            <br>
                                            <small class="text-muted">{{ $request->proposed_campus }} Campus</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $request->status_color }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        @if($request->event_id)
                                            <br>
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> Event Created
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $request->created_at->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('event-requests.show', $request) }}" 
                                               class="btn ju-btn-outline" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($request->isPending() && ($request->user_id == auth()->id() || auth()->user()->hasPermission('manage_events')))
                                            <a href="{{ route('event-requests.edit', $request) }}" 
                                               class="btn ju-btn-outline" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif
                                            
                                            @if($request->isPending() && $request->user_id == auth()->id())
                                            <form action="{{ route('event-requests.cancel', $request) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to cancel this request?')">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm" title="Cancel">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                            
                                            @if(auth()->user()->hasPermission('manage_events') && $request->isPending())
                                            <button type="button" class="btn btn-success btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}"
                                                    title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}"
                                                    title="Reject">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Approve Modal -->
                                @if(auth()->user()->hasPermission('manage_events') && $request->isPending())
                                <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header ju-modal-header">
                                                <h5 class="modal-title">Approve Event Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('event-requests.approve', $request) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Are you sure you want to approve this event request?</p>
                                                    <div class="mb-3">
                                                        <label for="review_notes{{ $request->id }}" class="form-label">Review Notes (Optional)</label>
                                                        <textarea class="form-control ju-input" id="review_notes{{ $request->id }}" 
                                                                  name="review_notes" rows="3"></textarea>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" 
                                                               id="make_public{{ $request->id }}" name="make_public" value="1" checked>
                                                        <label class="form-check-label" for="make_public{{ $request->id }}">
                                                            Make event public
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               id="is_featured{{ $request->id }}" name="is_featured" value="1">
                                                        <label class="form-check-label" for="is_featured{{ $request->id }}">
                                                            Mark as featured event
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn ju-btn-outline" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn ju-btn-success">Approve Request</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Reject Modal -->
                                @if(auth()->user()->hasPermission('manage_events') && $request->isPending())
                                <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header ju-modal-header">
                                                <h5 class="modal-title">Reject Event Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('event-requests.reject', $request) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Are you sure you want to reject this event request?</p>
                                                    <div class="mb-3">
                                                        <label for="reject_notes{{ $request->id }}" class="form-label">Reason for Rejection *</label>
                                                        <textarea class="form-control ju-input" id="reject_notes{{ $request->id }}" 
                                                                  name="review_notes" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn ju-btn-outline" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn ju-btn-danger">Reject Request</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                                            <h5>No Event Requests Found</h5>
                                            <p class="text-muted">
                                                @if(request()->hasAny(['search', 'status', 'event_type']))
                                                    Try adjusting your search filters
                                                @else
                                                    Get started by submitting your first event request
                                                @endif
                                            </p>
                                            <a href="{{ route('event-requests.create') }}" class="btn ju-btn-primary mt-2">
                                                <i class="fas fa-plus-circle me-1"></i> New Request
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($requests->hasPages())
                    <div class="row mt-4">
                        <div class="col-12">
                            {{ $requests->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.ju-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 0.5rem 1rem;
}

.ju-tabs .nav-link.active {
    color: var(--ju-primary);
    border-bottom: 3px solid var(--ju-primary);
    background: transparent;
}

.empty-state {
    padding: 2rem;
    text-align: center;
}
</style>
@endpush