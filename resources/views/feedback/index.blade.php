{{-- resources/views/feedback/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Feedback Management | Jimma University')
@section('page-title', 'Feedback Management')

@section('content')
<style>
    /* Enhanced Color Scheme - Jimma University Colors */
    :root {
        --ju-primary: #006747; /* Jimma University Green */
        --ju-secondary: #FFC72C; /* Jimma University Gold */
        --ju-accent: #00573D;
        --ju-light: #E8F4EA;
        --ju-dark: #003D28;
    }
    
    /* Modern Card Design */
    .stat-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }
    
    .stat-card-primary::before { background: linear-gradient(90deg, var(--ju-primary), var(--ju-accent)); }
    .stat-card-warning::before { background: linear-gradient(90deg, #FFC72C, #FFAA00); }
    .stat-card-info::before { background: linear-gradient(90deg, #3498db, #2980b9); }
    .stat-card-success::before { background: linear-gradient(90deg, #27ae60, #219653); }
    
    /* Enhanced Status Badges */
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .status-badge i {
        font-size: 0.8rem;
    }
    
    .status-pending {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    .status-reviewed {
        background: linear-gradient(135deg, #cce5ff, #a8d0fe);
        color: #004085;
        border: 1px solid #a8d0fe;
    }
    
    .status-resolved {
        background: linear-gradient(135deg, #d4edda, #b8e0c2);
        color: #155724;
        border: 1px solid #b8e0c2;
    }
    
    .status-closed {
        background: linear-gradient(135deg, #e2e3e5, #d5d6d8);
        color: #383d41;
        border: 1px solid #d5d6d8;
    }
    
    /* Enhanced Feedback Cards */
    .feedback-row {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .feedback-row:hover {
        background: linear-gradient(90deg, rgba(0, 103, 71, 0.03), rgba(255, 199, 44, 0.02));
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-left-color: var(--ju-primary);
    }
    
    /* Type Badges Enhancement */
    .type-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .type-badge i {
        font-size: 0.7rem;
    }
    
    .type-event { 
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #1565c0;
        border: 1px solid #bbdefb;
    }
    
    .type-system { 
        background: linear-gradient(135deg, #f3e5f5, #e1bee7);
        color: #7b1fa2;
        border: 1px solid #e1bee7;
    }
    
    .type-general { 
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }
    
    .type-suggestion { 
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        color: #ef6c00;
        border: 1px solid #ffe0b2;
    }
    
    .type-complaint { 
        background: linear-gradient(135deg, #ffebee, #ffcdd2);
        color: #c62828;
        border: 1px solid #ffcdd2;
    }
    
    /* Enhanced Rating Stars */
    .rating-stars {
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    
    .rating-stars .fas.fa-star {
        color: #FFC72C;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    /* Enhanced Filter Section */
    .filter-section {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border-radius: 12px;
        border: 1px solid #e9ecef;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    
    .filter-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: white;
        padding: 10px;
    }
    
    .filter-select:focus {
        border-color: var(--ju-primary);
        box-shadow: 0 0 0 3px rgba(0, 103, 71, 0.1);
    }
    
    /* Enhanced Action Buttons */
    .action-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Enhanced Table Design */
    .enhanced-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .enhanced-table thead th {
        background: linear-gradient(135deg, var(--ju-primary), var(--ju-accent));
        color: white;
        font-weight: 600;
        border: none;
        padding: 16px 12px;
        position: relative;
    }
    
    .enhanced-table thead th:first-child {
        border-radius: 12px 0 0 0;
    }
    
    .enhanced-table thead th:last-child {
        border-radius: 0 12px 0 0;
    }
    
    .enhanced-table tbody td {
        padding: 16px 12px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    
    /* Empty State Design */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
        border: 2px dashed #dee2e6;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        color: var(--ju-primary);
        opacity: 0.3;
        margin-bottom: 20px;
    }
    
    /* Enhanced Pagination */
    .enhanced-pagination .page-link {
        border: none;
        color: var(--ju-primary);
        border-radius: 8px;
        margin: 0 4px;
        transition: all 0.3s ease;
    }
    
    .enhanced-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, var(--ju-primary), var(--ju-accent));
        color: white;
    }
    
    .enhanced-pagination .page-link:hover {
        background: linear-gradient(135deg, var(--ju-light), #d4edda);
    }
    
    /* Quick Action Buttons */
    .quick-action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
        background: white;
    }
    
    .quick-action-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Responsive Design Improvements */
    @media (max-width: 768px) {
        .stat-card .icon {
            display: none;
        }
        
        .enhanced-table {
            display: block;
            overflow-x: auto;
        }
        
        .filter-section .row > div {
            margin-bottom: 15px;
        }
    }
</style>

<div class="container-fluid">
    <!-- Page Header with University Branding -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: var(--ju-primary);">
                        <i class="fas fa-comments me-2"></i>Feedback Management
                    </h1>
                    <p class="text-muted mb-0">Monitor and manage all user feedback for Jimma University</p>
                </div>
                <div class="ju-badge" style="
                    background: linear-gradient(135deg, var(--ju-primary), var(--ju-accent));
                    color: white;
                    padding: 8px 20px;
                    border-radius: 20px;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                ">
                    <i class="fas fa-university"></i>
                    Jimma University
                </div>
            </div>
            <hr style="border-color: rgba(0, 103, 71, 0.2);">
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-primary position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.85rem;">TOTAL FEEDBACK</h6>
                            <h2 class="mb-0" style="color: var(--ju-primary);">{{ $statistics['total'] }}</h2>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.85rem;">
                                <i class="fas fa-arrow-up text-success me-1"></i>
                                Last 30 days: +{{ $statistics['last_month'] ?? 0 }}
                            </p>
                        </div>
                        <div class="icon" style="color: rgba(0, 103, 71, 0.2);">
                            <i class="fas fa-comments fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-warning position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.85rem;">PENDING REVIEW</h6>
                            <h2 class="mb-0" style="color: #FFC72C;">{{ $statistics['pending'] }}</h2>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.85rem;">
                                <i class="fas fa-clock me-1"></i>
                                Requires attention
                            </p>
                        </div>
                        <div class="icon" style="color: rgba(255, 199, 44, 0.2);">
                            <i class="fas fa-clock fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-info position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.85rem;">UNDER REVIEW</h6>
                            <h2 class="mb-0" style="color: #3498db;">{{ $statistics['reviewed'] }}</h2>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.85rem;">
                                <i class="fas fa-eye me-1"></i>
                                Currently reviewing
                            </p>
                        </div>
                        <div class="icon" style="color: rgba(52, 152, 219, 0.2);">
                            <i class="fas fa-eye fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card stat-card-success position-relative">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted text-uppercase mb-1" style="font-size: 0.85rem;">RESOLVED</h6>
                            <h2 class="mb-0" style="color: #27ae60;">{{ $statistics['resolved'] }}</h2>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.85rem;">
                                <i class="fas fa-check me-1"></i>
                               {{ $statistics['total'] > 0 ? round(($statistics['resolved']/$statistics['total'])*100, 1) : 0 }}% resolved
                            </p>
                        </div>
                        <div class="icon" style="color: rgba(39, 174, 96, 0.2);">
                            <i class="fas fa-check-circle fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filters and Actions -->
    <div class="card mb-4 filter-section">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-3" style="color: var(--ju-primary);">
                        <i class="fas fa-filter me-2"></i>Filter Feedback
                    </h5>
                    <form action="{{ route('feedback.index') }}" method="GET" class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small text-muted mb-1">Status</label>
                            <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    <i class="fas fa-clock me-1"></i> Pending
                                </option>
                                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>
                                    <i class="fas fa-eye me-1"></i> Reviewed
                                </option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>
                                    <i class="fas fa-check me-1"></i> Resolved
                                </option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>
                                    <i class="fas fa-times me-1"></i> Closed
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small text-muted mb-1">Feedback Type</label>
                            <select name="type" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>
                                    <i class="fas fa-calendar-alt me-1"></i> Event
                                </option>
                                <option value="system" {{ request('type') == 'system' ? 'selected' : '' }}>
                                    <i class="fas fa-desktop me-1"></i> System
                                </option>
                                <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>
                                    <i class="fas fa-comment me-1"></i> General
                                </option>
                                <option value="suggestion" {{ request('type') == 'suggestion' ? 'selected' : '' }}>
                                    <i class="fas fa-lightbulb me-1"></i> Suggestion
                                </option>
                                <option value="complaint" {{ request('type') == 'complaint' ? 'selected' : '' }}>
                                    <i class="fas fa-exclamation-circle me-1"></i> Complaint
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small text-muted mb-1">Rating</label>
                            <select name="rating" class="form-select filter-select" onchange="this.form.submit()">
                                <option value="">All Ratings</option>
                                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>
                                    <i class="fas fa-star text-warning me-1"></i> 5 Stars
                                </option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>
                                    <i class="fas fa-star text-warning me-1"></i> 4+ Stars
                                </option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>
                                    <i class="fas fa-star text-warning me-1"></i> 3+ Stars
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small text-muted mb-1">Search</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control filter-select" 
                                       placeholder="Search feedback..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit" style="
                                    background: linear-gradient(135deg, var(--ju-primary), var(--ju-accent));
                                    border: none;
                                    border-radius: 0 8px 8px 0;
                                ">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <h5 class="mb-3" style="color: var(--ju-primary);">
                        <i class="fas fa-cogs me-2"></i>Quick Actions
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('feedback.analytics') }}" class="action-btn btn btn-outline-info">
                            <i class="fas fa-chart-bar"></i>
                            <span class="d-none d-md-inline">Analytics</span>
                        </a>
                        <a href="{{ route('feedback.export') }}" class="action-btn btn btn-outline-success">
                            <i class="fas fa-download"></i>
                            <span class="d-none d-md-inline">Export</span>
                        </a>
                        <a href="{{ route('feedback.testimonials') }}" class="action-btn btn btn-outline-primary">
                            <i class="fas fa-eye"></i>
                            <span class="d-none d-md-inline">View Public</span>
                        </a>
                        <button class="action-btn btn btn-warning" onclick="refreshPage()">
                            <i class="fas fa-sync-alt"></i>
                            <span class="d-none d-md-inline">Refresh</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Feedback List -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-bottom: 2px solid rgba(0, 103, 71, 0.1);
        ">
            <h5 class="mb-0" style="color: var(--ju-primary);">
                <i class="fas fa-list me-2"></i>Feedback Entries
                <span class="badge bg-primary ms-2">{{ $feedbacks->total() }}</span>
            </h5>
            <div class="small text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Click on any row for details
            </div>
        </div>
        <div class="card-body p-0">
            @if($feedbacks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover enhanced-table mb-0">
                        <thead>
                            <tr>
                                <th width="80">ID</th>
                                <th width="120">Type</th>
                                <th>Subject & Details</th>
                                <th width="180">Submitted By</th>
                                <th width="150">Rating</th>
                                <th width="120">Status</th>
                                <th width="150">Submitted</th>
                                <th width="140" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $feedback)
                            <tr class="feedback-row" onclick="window.location.href='{{ route('feedback.show', $feedback) }}'" style="cursor: pointer;">
                                <td>
                                    <span class="badge bg-dark">#{{ str_pad($feedback->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <span class="type-badge type-{{ $feedback->type }}">
                                        <i class="fas 
                                            {{ $feedback->type == 'event' ? 'fa-calendar-alt' : '' }}
                                            {{ $feedback->type == 'system' ? 'fa-desktop' : '' }}
                                            {{ $feedback->type == 'general' ? 'fa-comment' : '' }}
                                            {{ $feedback->type == 'suggestion' ? 'fa-lightbulb' : '' }}
                                            {{ $feedback->type == 'complaint' ? 'fa-exclamation-circle' : '' }}
                                        "></i>
                                        {{ ucfirst($feedback->type) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <strong class="mb-1">{{ $feedback->subject ?: 'No Subject' }}</strong>
                                        <div class="small text-muted">
                                            {{ Str::limit(strip_tags($feedback->message), 60) }}
                                        </div>
                                        <div class="mt-1">
                                            @if($feedback->is_public)
                                                <span class="badge bg-success" style="font-size: 0.7rem;">
                                                    <i class="fas fa-eye me-1"></i> Public
                                                </span>
                                            @endif
                                            @if($feedback->featured)
                                                <span class="badge bg-warning" style="font-size: 0.7rem;">
                                                    <i class="fas fa-star me-1"></i> Featured
                                                </span>
                                            @endif
                                            @if($feedback->event)
                                                <span class="badge bg-info" style="font-size: 0.7rem;">
                                                    <i class="fas fa-calendar me-1"></i> Event
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--ju-light), #d4edda);">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong class="d-block">
                                                @if($feedback->user)
                                                    {{ $feedback->user->name }}
                                                @else
                                                    {{ $feedback->name ?: 'Anonymous' }}
                                                @endif
                                            </strong>
                                            @if($feedback->email)
                                                <small class="text-muted">{{ $feedback->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($feedback->rating)
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $feedback->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star text-muted"></i>
                                                @endif
                                            @endfor
                                            <div class="mt-1">
                                                <small class="badge bg-light text-dark">
                                                    {{ $feedback->rating }}/5
                                                </small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">No rating</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $feedback->status }}">
                                        <i class="fas 
                                            {{ $feedback->status == 'pending' ? 'fa-clock' : '' }}
                                            {{ $feedback->status == 'reviewed' ? 'fa-eye' : '' }}
                                            {{ $feedback->status == 'resolved' ? 'fa-check' : '' }}
                                            {{ $feedback->status == 'closed' ? 'fa-times' : '' }}
                                        "></i>
                                        {{ ucfirst($feedback->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="fw-bold">{{ $feedback->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted">{{ $feedback->created_at->format('h:i A') }}</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('feedback.show', $feedback) }}" 
                                           class="quick-action-btn btn btn-sm btn-primary"
                                           title="View Details"
                                           onclick="event.stopPropagation();">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="quick-action-btn btn btn-sm btn-info"
                                                onclick="togglePublic({{ $feedback->id }}); event.stopPropagation();"
                                                title="{{ $feedback->is_public ? 'Make Private' : 'Make Public' }}">
                                            <i class="fas fa-eye{{ $feedback->is_public ? '' : '-slash' }}"></i>
                                        </button>
                                        @if($feedback->is_public)
                                        <button class="quick-action-btn btn btn-sm btn-warning"
                                                onclick="toggleFeatured({{ $feedback->id }}); event.stopPropagation();"
                                                title="{{ $feedback->featured ? 'Unfeature' : 'Feature' }}">
                                            <i class="fas fa-star{{ $feedback->featured ? '' : '-o' }}"></i>
                                        </button>
                                        @endif
                                        <button class="quick-action-btn btn btn-sm btn-danger"
                                                onclick="deleteFeedback({{ $feedback->id }}); event.stopPropagation();"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Enhanced Pagination -->
                <div class="d-flex justify-content-between align-items-center p-4 border-top">
                    <div class="small text-muted">
                        Showing <strong>{{ $feedbacks->firstItem() }}</strong> to 
                        <strong>{{ $feedbacks->lastItem() }}</strong> of 
                        <strong>{{ $feedbacks->total() }}</strong> entries
                        @if(request()->has('status') || request()->has('type') || request()->has('rating'))
                            <span class="ms-2 text-primary">
                                <i class="fas fa-filter me-1"></i>Filtered
                            </span>
                        @endif
                    </div>
                    <div class="enhanced-pagination">
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h4 class="mb-3" style="color: var(--ju-primary);">No Feedback Found</h4>
                    <p class="text-muted mb-4">There are no feedback entries matching your criteria.</p>
                    <a href="{{ route('feedback.index') }}" class="btn btn-primary">
                        <i class="fas fa-sync-alt me-2"></i>Reset Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePublic(feedbackId) {
    event.preventDefault();
    if (confirm('Are you sure you want to change the visibility of this feedback?')) {
        fetch(`/feedback/admin/${feedbackId}/toggle-public`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Visibility updated successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }
}

function toggleFeatured(feedbackId) {
    event.preventDefault();
    if (confirm('Are you sure you want to toggle featured status?')) {
        fetch(`/feedback/admin/${feedbackId}/toggle-featured`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Featured status updated successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else if (data.message) {
                showNotification(data.message, 'warning');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }
}

function deleteFeedback(feedbackId) {
    event.preventDefault();
    if (confirm('Are you sure you want to delete this feedback? This action cannot be undone.')) {
        fetch(`/feedback/admin/${feedbackId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Feedback deleted successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    }
}

function refreshPage() {
    location.reload();
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    notification.innerHTML = `
        <strong>${type.charAt(0).toUpperCase() + type.slice(1)}!</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+F to focus search
    if (e.ctrlKey && e.key === 'f') {
        e.preventDefault();
        document.querySelector('input[name="search"]').focus();
    }
    // F5 to refresh
    if (e.key === 'F5') {
        e.preventDefault();
        refreshPage();
    }
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection