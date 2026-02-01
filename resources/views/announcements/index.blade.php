@extends('layouts.app')

@section('title', 'Announcements - Jimma University')
@section('page-title', 'Announcements')
@section('page-subtitle', 'University Updates & Important Notices')

@section('breadcrumb-items')
<li class="breadcrumb-item active">Announcements</li>
@endsection

@section('content')
<style>
    .announcement-card {
        transition: all 0.3s ease;
        border-left: 4px solid;
        height: 100%;
    }

    .announcement-card.event {
        border-left-color: #3498db;
    }

    .announcement-card.campus {
        border-left-color: #2ecc71;
    }

    .announcement-card.general {
        border-left-color: #9b59b6;
    }

    .announcement-card.urgent {
        border-left-color: #e74c3c;
        border-left-width: 6px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.4);
        }

        50% {
            box-shadow: 0 0 0 10px rgba(231, 76, 60, 0);
        }
    }

    .announcement-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }

    .audience-badge {
        font-size: 0.7rem;
        padding: 2px 8px;
    }

    .status-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 0.65rem;
    }

    .excerpt {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .views-count {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .filter-sidebar {
        position: sticky;
        top: 20px;
    }

    .announcement-meta {
        font-size: 0.85rem;
        color: #6c757d;
    }
</style>

<div class="container-fluid">
    <!-- Stats Cards -->
    @if(auth()->check() && auth()->user()->hasPermission('view_announcement_stats'))
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <i class="fas fa-bullhorn stat-icon"></i>
                <div class="stat-number">{{ $stats['totalAnnouncements'] }}</div>
                <div class="stat-label">Total Announcements</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-success">
                <i class="fas fa-eye stat-icon"></i>
                <div class="stat-number">{{ $stats['publishedAnnouncements'] }}</div>
                <div class="stat-label">Published</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-info">
                <i class="fas fa-clock stat-icon"></i>
                <div class="stat-number">{{ $stats['activeAnnouncements'] }}</div>
                <div class="stat-label">Active</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-warning">
                <i class="fas fa-chart-line stat-icon"></i>
                <div class="stat-number">{{ $stats['totalViews'] }}</div>
                <div class="stat-label">Total Views</div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="ju-card filter-sidebar">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-filter me-2"></i>Filters
                    </h5>
                </div>
                <div class="ju-card-body">
                    <form id="filterForm" method="GET" action="{{ route('announcements.index') }}">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label">Search</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search announcements..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Type Filter -->
                        <div class="mb-4">
                            <label class="form-label">Announcement Type</label>
                            <select name="type" class="form-select" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>General</option>
                                <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Event</option>
                                <option value="campus" {{ request('type') == 'campus' ? 'selected' : '' }}>Campus</option>
                                <option value="urgent" {{ request('type') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>

                        <!-- Audience Filter -->
                        @if(auth()->check() && auth()->user()->hasPermission('manage_announcements'))
                        <div class="mb-4">
                            <label class="form-label">Audience</label>
                            <select name="audience" class="form-select" onchange="this.form.submit()">
                                <option value="">All Audiences</option>
                                <option value="all" {{ request('audience') == 'all' ? 'selected' : '' }}>Everyone</option>
                                <option value="students" {{ request('audience') == 'students' ? 'selected' : '' }}>Students</option>
                                <option value="faculty" {{ request('audience') == 'faculty' ? 'selected' : '' }}>Faculty</option>
                                <option value="staff" {{ request('audience') == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="specific" {{ request('audience') == 'specific' ? 'selected' : '' }}>Specific Users</option>
                            </select>
                        </div>
                        @endif

                        <!-- Status Filter (for admins) -->
                        @if(auth()->check() && auth()->user()->hasPermission('manage_announcements'))
                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        @endif

                        <!-- Expiration Filter -->
                        <div class="mb-4">
                            <label class="form-label">Expiration</label>
                            <select name="expired" class="form-select" onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="no" {{ request('expired') == 'no' ? 'selected' : '' }}>Active Only</option>
                                <option value="yes" {{ request('expired') == 'yes' ? 'selected' : '' }}>Expired Only</option>
                            </select>
                        </div>

                        <!-- Clear Filters -->
                        @if(request()->hasAny(['search', 'type', 'audience', 'status', 'expired']))
                        <div class="d-grid">
                            <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Clear Filters
                            </a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            @auth
            <div class="ju-card mt-4">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="ju-card-body">
                    <div class="d-grid gap-2">
                        @can('create_announcements')
                        <a href="{{ route('announcements.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Create Announcement
                        </a>
                        @endcan

                        @can('view_announcement_stats')
                        <a href="{{ route('announcements.statistics') }}" class="btn btn-outline-info">
                            <i class="fas fa-chart-bar me-2"></i>View Statistics
                        </a>
                        @endcan

                        @if(auth()->user()->hasPermission('manage_announcements'))
                        <button class="btn btn-outline-warning" onclick="exportAnnouncements()">
                            <i class="fas fa-download me-2"></i>Export Data
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endauth
        </div>

        <!-- Announcements Grid -->
        <div class="col-lg-9">
            <!-- Header with Actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-0">All Announcements</h3>
                    <p class="text-muted mb-0">
                        Showing {{ $announcements->firstItem() }}-{{ $announcements->lastItem() }} of {{ $announcements->total() }} announcements
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <!-- View Toggle -->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" id="gridViewBtn">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="listViewBtn">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-sort me-2"></i>Sort
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest First</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">Oldest First</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'views']) }}">Most Viewed</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'urgent']) }}">Urgent First</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Announcements Grid/List -->
            <div id="announcementsContainer" class="row" data-view="grid">
                @forelse($announcements as $announcement)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="ju-card announcement-card {{ $announcement->type }}">
                        @if(!$announcement->is_published)
                        <span class="status-badge badge bg-warning">
                            <i class="fas fa-clock me-1"></i>Draft
                        </span>
                        @endif

                        @if($announcement->expires_at && $announcement->expires_at->isPast())
                        <span class="status-badge badge bg-secondary">
                            <i class="fas fa-history me-1"></i>Expired
                        </span>
                        @endif

                        <div class="ju-card-body">
                            <!-- Type Icon -->
                            <div class="text-center mb-3">
                                @switch($announcement->type)
                                @case('event')
                                <i class="fas fa-calendar-alt announcement-icon text-primary"></i>
                                @break
                                @case('campus')
                                <i class="fas fa-university announcement-icon text-success"></i>
                                @break
                                @case('urgent')
                                <i class="fas fa-exclamation-triangle announcement-icon text-danger"></i>
                                @break
                                @default
                                <i class="fas fa-bullhorn announcement-icon text-purple"></i>
                                @endswitch
                            </div>

                            <!-- Title -->
                            <h5 class="ju-card-title mb-2">
                                <a href="{{ route('announcements.show', $announcement) }}"
                                    class="text-decoration-none text-dark">
                                    {{ Str::limit($announcement->title, 60) }}
                                </a>
                            </h5>

                            <!-- Excerpt -->
                            <p class="excerpt text-muted mb-3">
                                {{ strip_tags(Str::limit($announcement->content, 150)) }}
                            </p>

                            <!-- Meta Information -->
                            <div class="announcement-meta">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <i class="fas fa-user me-1"></i>
                                        {{ $announcement->creator->name ?? 'System' }}
                                    </div>
                                    <div class="views-count">
                                        <i class="fas fa-eye me-1"></i>{{ $announcement->views }}
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $announcement->created_at->format('M d, Y') }}
                                    </div>

                                    <span class="badge audience-badge bg-{{ $announcement->type == 'urgent' ? 'danger' : 'secondary' }}">
                                        {{ $announcement->getAudienceLabel() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="ju-card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($announcement->expires_at)
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Expires: {{ $announcement->expires_at->format('M d') }}
                                    </small>
                                    @endif
                                </div>

                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('announcements.show', $announcement) }}"
                                        class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @can('update', $announcement)
                                    <a href="{{ route('announcements.edit', $announcement) }}"
                                        class="btn btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan

                                    @can('delete', $announcement)
                                    <form action="{{ route('announcements.destroy', $announcement) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="ju-card text-center py-5">
                        <i class="fas fa-bullhorn fa-4x text-muted mb-3"></i>
                        <h4>No Announcements Found</h4>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'type', 'audience', 'status', 'expired']))
                            Try adjusting your filters or search terms.
                            @else
                            There are no announcements available at the moment.
                            @endif
                        </p>
                        @can('create_announcements')
                        <a href="{{ route('announcements.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus-circle me-2"></i>Create First Announcement
                        </a>
                        @endcan
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($announcements->hasPages())
            <div class="mt-4">
                {{ $announcements->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Export Modal -->
@if(auth()->check() && auth()->user()->hasPermission('manage_announcements'))
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content ju-card">
            <div class="modal-header ju-card-header">
                <h5 class="modal-title">
                    <i class="fas fa-download me-2"></i>Export Announcements
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body ju-card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Export feature coming soon!</strong><br>
                    This feature is currently under development.
                    You can view statistics from the Statistics page.
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('announcements.statistics') }}" class="btn btn-primary">
                        <i class="fas fa-chart-bar me-2"></i>View Statistics
                    </a>
                </div>
            </div>
            <div class="modal-footer ju-card-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // View Toggle
    document.getElementById('gridViewBtn').addEventListener('click', function() {
        document.getElementById('announcementsContainer').setAttribute('data-view', 'grid');
        this.classList.add('active');
        document.getElementById('listViewBtn').classList.remove('active');

        const cards = document.querySelectorAll('#announcementsContainer .col');
        cards.forEach(card => {
            card.className = 'col-xl-4 col-lg-6 col-md-6 mb-4';
        });
    });

    document.getElementById('listViewBtn').addEventListener('click', function() {
        document.getElementById('announcementsContainer').setAttribute('data-view', 'list');
        this.classList.add('active');
        document.getElementById('gridViewBtn').classList.remove('active');

        const cards = document.querySelectorAll('#announcementsContainer .col');
        cards.forEach(card => {
            card.className = 'col-12 mb-4';
        });
    });

    // Export function
    function exportAnnouncements() {
        const exportModal = new bootstrap.Modal(document.getElementById('exportModal'));
        exportModal.show();
    }

    // Auto-submit filters
    document.querySelectorAll('#filterForm select').forEach(select => {
        select.addEventListener('change', function() {
            // Don't submit if this is already handled
            if (!this.hasAttribute('onchange')) {
                document.getElementById('filterForm').submit();
            }
        });
    });

    // Real-time search
    let searchTimeout;
    document.querySelector('input[name="search"]').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            document.querySelector('input[name="search"]').focus();
        }

        // Ctrl/Cmd + N to create new (if authorized)
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            @can('create_announcements')
            window.location.href = "{{ route('announcements.create') }}";
            @endcan
        }
    });

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush