{{-- resources/views/feedback/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Feedback Management | Jimma University')
@section('page-title', 'Feedback Management')
@section('page-subtitle', 'Monitor and manage all user feedback and testimonials')

@section('breadcrumb-items')
<li class="breadcrumb-item active" aria-current="page">Feedback Management</li>
@endsection

@section('content')
<style>
    /* ============================================
       JIMMA UNIVERSITY OFFICIAL BLUE SCHEME
       Royal Blue (#002789) & Gold (#C4A747) - Matching Layout Exactly
    ============================================ */
    :root {
        --ju-blue: #002789;
        --ju-blue-dark: #001a5c;
        --ju-blue-darker: #021230;
        --ju-blue-light: #1a3a9a;
        --ju-blue-lighter: #3a6ab0;
        --ju-blue-soft: #e6ebf7;
        --ju-blue-glow: rgba(0, 39, 137, 0.2);
        --ju-blue-gradient: linear-gradient(145deg, #002789, #001a5c);
        
        --ju-gold: #C4A747;
        --ju-gold-dark: #a5862e;
        --ju-gold-light: #e5d6a6;
        --ju-gold-soft: rgba(196, 167, 71, 0.12);
        --ju-gold-gradient: linear-gradient(145deg, #C4A747, #a5862e);
        
        --ju-white: #ffffff;
        --ju-offwhite: #f9f9f9;
        --ju-gray: #f0f0f0;
        --ju-gray-dark: #333333;
        --ju-gray-600: #64748b;
        
        --shadow-xs: 0 2px 4px rgba(0,39,137,0.02);
        --shadow-sm: 0 4px 6px rgba(0,39,137,0.04);
        --shadow: 0 6px 12px rgba(0,39,137,0.06);
        --shadow-md: 0 8px 24px rgba(0,39,137,0.08);
        --shadow-lg: 0 16px 32px rgba(0,39,137,0.1);
        --shadow-xl: 0 24px 48px rgba(0,39,137,0.12);
        --shadow-2xl: 0 32px 64px rgba(0,39,137,0.15);
        --shadow-gold: 0 8px 20px rgba(196,167,71,0.2);
        
        --radius-sm: 0.25rem;
        --radius: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --radius-2xl: 1.25rem;
        --radius-full: 9999px;
        
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-bounce: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        --transition-elastic: all 0.6s cubic-bezier(0.68, -0.6, 0.32, 1.6);
    }

    /* ============================================
       ENHANCED STAT CARDS - ROYAL BLUE THEME
    ============================================ */
    .ju-stat-card {
        background: var(--ju-white);
        border: 1px solid var(--ju-gray);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow);
        transition: var(--transition-bounce);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .ju-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--ju-blue-gradient);
    }

    .ju-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-2xl);
        border-color: var(--ju-blue);
    }

    .ju-stat-card .stat-icon {
        width: 60px;
        height: 60px;
        background: var(--ju-blue-soft);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ju-blue);
        font-size: 1.8rem;
        transition: var(--transition-bounce);
    }

    .ju-stat-card:hover .stat-icon {
        background: var(--ju-blue-gradient);
        color: var(--ju-white);
        transform: rotate(8deg) scale(1.1);
    }

    .ju-stat-card .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--ju-blue);
        line-height: 1;
        margin-bottom: 0.25rem;
        font-family: 'Montserrat', sans-serif;
    }

    .ju-stat-card .stat-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--ju-gray-dark);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .ju-stat-card .stat-trend {
        font-size: 0.8rem;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        background: var(--ju-blue-soft);
        color: var(--ju-blue);
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* ============================================
       ENHANCED STATUS BADGES - ROYAL BLUE SCHEME
    ============================================ */
    .ju-status-badge {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid transparent;
        transition: var(--transition);
        letter-spacing: 0.3px;
    }

    .ju-status-badge i {
        font-size: 0.75rem;
    }

    .ju-status-pending {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #856404;
        border-color: #ffeaa7;
    }

    .ju-status-reviewed {
        background: linear-gradient(135deg, var(--ju-blue-soft), #d4e0f0);
        color: var(--ju-blue);
        border-color: var(--ju-blue-soft);
    }

    .ju-status-resolved {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border-color: #c3e6cb;
    }

    .ju-status-closed {
        background: linear-gradient(135deg, #e2e3e5, #d6d8d9);
        color: #383d41;
        border-color: #d6d8d9;
    }

    /* ============================================
       ENHANCED TYPE BADGES - ROYAL BLUE SCHEME
    ============================================ */
    .ju-type-badge {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid transparent;
        transition: var(--transition);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .ju-type-event {
        background: linear-gradient(135deg, var(--ju-blue-soft), #d4e0f0);
        color: var(--ju-blue);
        border-color: var(--ju-blue-soft);
    }

    .ju-type-system {
        background: linear-gradient(135deg, #e8eaf6, #c5cae9);
        color: #3949ab;
        border-color: #c5cae9;
    }

    .ju-type-general {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #2e7d32;
        border-color: #c8e6c9;
    }

    .ju-type-suggestion {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        color: #ef6c00;
        border-color: #ffe0b2;
    }

    .ju-type-complaint {
        background: linear-gradient(135deg, #ffebee, #ffcdd2);
        color: #c62828;
        border-color: #ffcdd2;
    }

    /* ============================================
       RATING STARS - JU GOLD
    ============================================ */
    .ju-rating {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .ju-rating .fa-star,
    .ju-rating .fas.fa-star {
        color: var(--ju-gold);
        filter: drop-shadow(0 2px 4px rgba(196, 167, 71, 0.2));
    }

    .ju-rating .far.fa-star {
        color: #ddd;
    }

    .ju-rating-score {
        background: var(--ju-gold-light);
        color: var(--ju-blue-dark);
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 700;
        margin-left: 0.5rem;
    }

    /* ============================================
       FILTER SECTION - ROYAL BLUE THEME
    ============================================ */
    .ju-filter-section {
        background: var(--ju-white);
        border: 1px solid var(--ju-gray);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow);
        padding: 1.5rem;
    }

    .ju-filter-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--ju-blue);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .ju-filter-select {
        border: 2px solid var(--ju-gray);
        border-radius: var(--radius-full);
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        color: var(--ju-gray-dark);
        background: var(--ju-white);
        transition: var(--transition);
        cursor: pointer;
    }

    .ju-filter-select:hover {
        border-color: var(--ju-blue);
    }

    .ju-filter-select:focus {
        border-color: var(--ju-blue);
        box-shadow: 0 0 0 4px rgba(0, 39, 137, 0.1);
        outline: none;
    }

    .ju-search-group {
        position: relative;
    }

    .ju-search-input {
        border: 2px solid var(--ju-gray);
        border-radius: var(--radius-full);
        padding: 0.6rem 1.2rem 0.6rem 2.8rem;
        font-size: 0.9rem;
        width: 100%;
        transition: var(--transition);
    }

    .ju-search-input:focus {
        border-color: var(--ju-blue);
        box-shadow: 0 0 0 4px rgba(0, 39, 137, 0.1);
        outline: none;
    }

    .ju-search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--ju-blue);
        font-size: 0.9rem;
    }

    /* ============================================
       ENHANCED TABLE - ROYAL BLUE THEME
    ============================================ */
    .ju-table-container {
        background: var(--ju-white);
        border: 1px solid var(--ju-gray);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .ju-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ju-table thead th {
        background: var(--ju-blue-gradient);
        color: var(--ju-white);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 1.2rem 1rem;
        border: none;
        white-space: nowrap;
    }

    .ju-table thead th:first-child {
        border-radius: var(--radius-xl) 0 0 0;
    }

    .ju-table thead th:last-child {
        border-radius: 0 var(--radius-xl) 0 0;
    }

    .ju-table tbody tr {
        transition: var(--transition);
        border-bottom: 1px solid var(--ju-gray);
    }

    .ju-table tbody tr:hover {
        background: linear-gradient(90deg, var(--ju-blue-soft), rgba(230, 235, 247, 0.3));
        transform: translateX(5px);
        box-shadow: var(--shadow);
    }

    .ju-table tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        color: var(--ju-gray-dark);
        font-size: 0.9rem;
    }

    /* ============================================
       FEEDBACK ROW - INTERACTIVE
    ============================================ */
    .ju-feedback-row {
        cursor: pointer;
        position: relative;
    }

    .ju-feedback-row::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: var(--ju-gold);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .ju-feedback-row:hover::before {
        opacity: 1;
    }

    /* ============================================
       QUICK ACTION BUTTONS
    ============================================ */
    .ju-action-btn {
        width: 36px;
        height: 36px;
        border-radius: var(--radius);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--ju-gray);
        background: var(--ju-white);
        color: var(--ju-gray-dark);
        transition: var(--transition-bounce);
        margin: 0 2px;
    }

    .ju-action-btn:hover {
        transform: scale(1.15) rotate(8deg);
        box-shadow: var(--shadow-md);
        border-color: transparent;
    }

    .ju-action-btn.btn-view:hover {
        background: var(--ju-blue);
        color: var(--ju-white);
    }

    .ju-action-btn.btn-public:hover {
        background: var(--ju-gold);
        color: var(--ju-white);
        border-color: var(--ju-gold);
    }

    .ju-action-btn.btn-featured:hover {
        background: #f39c12;
        color: var(--ju-white);
        border-color: #f39c12;
    }

    .ju-action-btn.btn-delete:hover {
        background: #dc3545;
        color: var(--ju-white);
        border-color: #dc3545;
    }

    /* ============================================
       ENHANCED PAGINATION
    ============================================ */
    .ju-pagination {
        display: flex;
        gap: 0.25rem;
    }

    .ju-pagination .page-link {
        border: none;
        background: transparent;
        color: var(--ju-gray-dark);
        border-radius: var(--radius);
        padding: 0.6rem 1rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .ju-pagination .page-item.active .page-link {
        background: var(--ju-blue-gradient);
        color: var(--ju-white);
        box-shadow: var(--shadow);
    }

    .ju-pagination .page-link:hover {
        background: var(--ju-blue-soft);
        color: var(--ju-blue);
        transform: translateY(-2px);
    }

    /* ============================================
       EMPTY STATE - ROYAL BLUE THEME
    ============================================ */
    .ju-empty-state {
        padding: 4rem 2rem;
        text-align: center;
        background: linear-gradient(135deg, var(--ju-white), var(--ju-offwhite));
        border-radius: var(--radius-xl);
        border: 2px dashed var(--ju-blue-soft);
    }

    .ju-empty-state-icon {
        width: 100px;
        height: 100px;
        background: var(--ju-blue-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--ju-blue);
        font-size: 2.5rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* ============================================
       NOTIFICATION TOASTS
    ============================================ */
    .ju-notification {
        position: fixed;
        top: 90px;
        right: 20px;
        z-index: 9999;
        min-width: 350px;
        background: var(--ju-white);
        border-left: 4px solid;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        padding: 1rem 1.25rem;
        animation: slideInRight 0.3s ease-out;
    }

    .ju-notification-success { border-left-color: #28a745; }
    .ju-notification-error { border-left-color: #dc3545; }
    .ju-notification-warning { border-left-color: #ffc107; }
    .ju-notification-info { border-left-color: var(--ju-blue); }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* ============================================
       RESPONSIVE DESIGN
    ============================================ */
    @media (max-width: 768px) {
        .ju-stat-card .stat-number {
            font-size: 1.8rem;
        }
        
        .ju-table {
            min-width: 800px;
        }
        
        .ju-action-btn {
            width: 32px;
            height: 32px;
        }
        
        .ju-filter-section .col-md-6,
        .ju-filter-section .col-lg-3 {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {
        .ju-stat-card {
            margin-bottom: 1rem;
        }
        
        .ju-notification {
            min-width: calc(100% - 40px);
            right: 20px;
            left: 20px;
        }
        
        .ju-status-badge,
        .ju-type-badge {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- ============================================
         PAGE HEADER WITH JU BRANDING
    ============================================ -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1" style="color: var(--ju-blue);">
                <i class="fas fa-comments me-2" style="color: var(--ju-gold);"></i>Feedback Management
            </h1>
            <p class="page-subtitle mb-0">
                Monitor and manage all user feedback for Jimma University
            </p>
        </div>
        <div class="d-none d-md-flex align-items-center gap-3">
            <div class="text-end">
                <span class="d-block fw-bold" style="color: var(--ju-blue);">Last Updated</span>
                <small class="text-muted">{{ now()->format('F d, Y - h:i A') }}</small>
            </div>
            <div style="width: 1px; height: 40px; background: var(--ju-gray);"></div>
            <div style="background: var(--ju-blue-soft); padding: 0.5rem 1.2rem; border-radius: var(--radius-full);">
                <i class="fas fa-university me-2" style="color: var(--ju-blue);"></i>
                <span style="color: var(--ju-blue); font-weight: 600;">Jimma University</span>
            </div>
        </div>
    </div>

    <!-- ============================================
         STATISTICS CARDS - ROYAL BLUE THEME
    ============================================ -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="ju-stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">TOTAL FEEDBACK</div>
                            <div class="stat-number">{{ $statistics['total'] }}</div>
                            <div class="stat-trend mt-2">
                                <i class="fas fa-arrow-up"></i>
                                +{{ $statistics['last_month'] ?? 0 }} this month
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="ju-stat-card" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">PENDING REVIEW</div>
                            <div class="stat-number" style="color: var(--ju-gold);">{{ $statistics['pending'] }}</div>
                            <div class="stat-trend mt-2">
                                <i class="fas fa-clock"></i>
                                Requires attention
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="ju-stat-card" data-aos="fade-up" data-aos-delay="300">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">UNDER REVIEW</div>
                            <div class="stat-number" style="color: #3498db;">{{ $statistics['reviewed'] }}</div>
                            <div class="stat-trend mt-2">
                                <i class="fas fa-eye"></i>
                                Currently reviewing
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="ju-stat-card" data-aos="fade-up" data-aos-delay="400">
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">RESOLVED</div>
                            <div class="stat-number" style="color: #28a745;">{{ $statistics['resolved'] }}</div>
                            <div class="stat-trend mt-2">
                                <i class="fas fa-check-circle"></i>
                                {{ $statistics['total'] > 0 ? round(($statistics['resolved']/$statistics['total'])*100, 1) : 0 }}% resolved
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         FILTER SECTION - ROYAL BLUE THEME
    ============================================ -->
    <div class="ju-filter-section mb-4" data-aos="fade-up" data-aos-delay="500">
        <form action="{{ route('feedback.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-lg-3 col-md-6">
                <div class="ju-filter-label">
                    <i class="fas fa-tag me-1"></i>Status
                </div>
                <select name="status" class="ju-filter-select w-100" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>👁️ Reviewed</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>✅ Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>❌ Closed</option>
                </select>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="ju-filter-label">
                    <i class="fas fa-filter me-1"></i>Feedback Type
                </div>
                <select name="type" class="ju-filter-select w-100" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>📅 Event</option>
                    <option value="system" {{ request('type') == 'system' ? 'selected' : '' }}>💻 System</option>
                    <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>💬 General</option>
                    <option value="suggestion" {{ request('type') == 'suggestion' ? 'selected' : '' }}>💡 Suggestion</option>
                    <option value="complaint" {{ request('type') == 'complaint' ? 'selected' : '' }}>⚠️ Complaint</option>
                </select>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="ju-filter-label">
                    <i class="fas fa-star me-1"></i>Minimum Rating
                </div>
                <select name="rating" class="ju-filter-select w-100" onchange="this.form.submit()">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4+ Stars</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3+ Stars</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐ 2+ Stars</option>
                </select>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="ju-filter-label">
                    <i class="fas fa-search me-1"></i>Search
                </div>
                <div class="ju-search-group">
                    <i class="fas fa-search ju-search-icon"></i>
                    <input type="text" name="search" class="ju-search-input" 
                           placeholder="Search feedback..." value="{{ request('search') }}">
                </div>
            </div>
            
            <div class="col-12 mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if(request()->hasAny(['status', 'type', 'rating', 'search']))
                        <a href="{{ route('feedback.index') }}" class="btn btn-sm" style="
                            background: var(--ju-blue-soft);
                            color: var(--ju-blue);
                            border-radius: var(--radius-full);
                            padding: 0.5rem 1.5rem;
                            font-weight: 600;
                        ">
                            <i class="fas fa-times-circle me-1"></i>Clear Filters
                        </a>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('feedback.analytics') }}" class="btn btn-sm" style="
                            background: var(--ju-blue-soft);
                            color: var(--ju-blue);
                            border-radius: var(--radius-full);
                            padding: 0.5rem 1.5rem;
                            font-weight: 600;
                        ">
                            <i class="fas fa-chart-bar me-1"></i>Analytics
                        </a>
                        <a href="{{ route('feedback.export') }}" class="btn btn-sm" style="
                            background: var(--ju-blue-soft);
                            color: var(--ju-blue);
                            border-radius: var(--radius-full);
                            padding: 0.5rem 1.5rem;
                            font-weight: 600;
                        ">
                            <i class="fas fa-download me-1"></i>Export
                        </a>
                        <button onclick="location.reload()" class="btn btn-sm" style="
                            background: var(--ju-blue-gradient);
                            color: white;
                            border-radius: var(--radius-full);
                            padding: 0.5rem 1.5rem;
                            font-weight: 600;
                            border: none;
                        ">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ============================================
         FEEDBACK TABLE - ROYAL BLUE THEME
    ============================================ -->
    <div class="ju-table-container" data-aos="fade-up" data-aos-delay="600">
        @if($feedbacks->count() > 0)
        <div class="table-responsive">
            <table class="ju-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Subject & Details</th>
                        <th>Submitted By</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedbacks as $feedback)
                    <tr class="ju-feedback-row" onclick="window.location.href='{{ route('feedback.show', $feedback) }}'">
                        <td>
                            <span style="
                                background: var(--ju-blue-soft);
                                color: var(--ju-blue);
                                padding: 0.4rem 0.8rem;
                                border-radius: var(--radius);
                                font-weight: 700;
                                font-size: 0.8rem;
                            ">#{{ str_pad($feedback->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <span class="ju-type-badge ju-type-{{ $feedback->type }}">
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
                                <strong style="color: var(--ju-blue);">
                                    {{ $feedback->subject ?: 'No Subject' }}
                                </strong>
                                <small class="text-muted">
                                    {{ Str::limit(strip_tags($feedback->message), 80) }}
                                </small>
                                <div class="mt-2 d-flex gap-1">
                                    @if($feedback->is_public)
                                    <span style="
                                        background: rgba(40, 167, 69, 0.1);
                                        color: #28a745;
                                        padding: 0.2rem 0.6rem;
                                        border-radius: var(--radius-full);
                                        font-size: 0.65rem;
                                        font-weight: 700;
                                    ">
                                        <i class="fas fa-eye me-1"></i>Public
                                    </span>
                                    @endif
                                    @if($feedback->featured)
                                    <span style="
                                        background: rgba(196, 167, 71, 0.1);
                                        color: var(--ju-gold);
                                        padding: 0.2rem 0.6rem;
                                        border-radius: var(--radius-full);
                                        font-size: 0.65rem;
                                        font-weight: 700;
                                    ">
                                        <i class="fas fa-star me-1"></i>Featured
                                    </span>
                                    @endif
                                    @if($feedback->event_id)
                                    <span style="
                                        background: rgba(0, 39, 137, 0.1);
                                        color: var(--ju-blue);
                                        padding: 0.2rem 0.6rem;
                                        border-radius: var(--radius-full);
                                        font-size: 0.65rem;
                                        font-weight: 700;
                                    ">
                                        <i class="fas fa-calendar me-1"></i>Event
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div style="
                                    width: 40px;
                                    height: 40px;
                                    background: linear-gradient(135deg, var(--ju-blue-soft), #d4e0f0);
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    color: var(--ju-blue);
                                    font-weight: 700;
                                    font-size: 0.9rem;
                                    margin-right: 0.8rem;
                                ">
                                    @if($feedback->user)
                                        {{ strtoupper(substr($feedback->user->name, 0, 1)) }}
                                    @else
                                        {{ $feedback->name ? strtoupper(substr($feedback->name, 0, 1)) : 'A' }}
                                    @endif
                                </div>
                                <div>
                                    <strong class="d-block" style="color: var(--ju-blue);">
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
                                <div class="ju-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $feedback->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="ju-rating-score">{{ $feedback->rating }}/5</span>
                                </div>
                            @else
                                <span class="text-muted small">Not rated</span>
                            @endif
                        </td>
                        <td>
                            <span class="ju-status-badge ju-status-{{ $feedback->status }}">
                                <i class="fas 
                                    {{ $feedback->status == 'pending' ? 'fa-clock' : '' }}
                                    {{ $feedback->status == 'reviewed' ? 'fa-eye' : '' }}
                                    {{ $feedback->status == 'resolved' ? 'fa-check-circle' : '' }}
                                    {{ $feedback->status == 'closed' ? 'fa-times-circle' : '' }}
                                "></i>
                                {{ ucfirst($feedback->status) }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size: 0.85rem;">
                                <strong>{{ $feedback->created_at->format('M d, Y') }}</strong>
                                <div class="text-muted small">{{ $feedback->created_at->format('h:i A') }}</div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('feedback.show', $feedback) }}" 
                                   class="ju-action-btn btn-view"
                                   title="View Details"
                                   onclick="event.stopPropagation();">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="ju-action-btn btn-public"
                                        onclick="togglePublic({{ $feedback->id }}); event.stopPropagation();"
                                        title="{{ $feedback->is_public ? 'Make Private' : 'Make Public' }}">
                                    <i class="fas fa-eye{{ $feedback->is_public ? '' : '-slash' }}"></i>
                                </button>
                                @if($feedback->is_public)
                                <button class="ju-action-btn btn-featured"
                                        onclick="toggleFeatured({{ $feedback->id }}); event.stopPropagation();"
                                        title="{{ $feedback->featured ? 'Unfeature' : 'Feature' }}">
                                    <i class="fas fa-star{{ $feedback->featured ? '' : '-o' }}"></i>
                                </button>
                                @endif
                                <button class="ju-action-btn btn-delete"
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

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center p-4 border-top" style="border-color: var(--ju-gray) !important;">
            <div class="small text-muted">
                <i class="fas fa-info-circle me-1" style="color: var(--ju-blue);"></i>
                Showing <strong style="color: var(--ju-blue);">{{ $feedbacks->firstItem() }}</strong> 
                to <strong style="color: var(--ju-blue);">{{ $feedbacks->lastItem() }}</strong> 
                of <strong style="color: var(--ju-blue);">{{ $feedbacks->total() }}</strong> entries
            </div>
            <div class="ju-pagination">
                {{ $feedbacks->onEachSide(2)->links() }}
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="ju-empty-state">
            <div class="ju-empty-state-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h4 style="color: var(--ju-blue); margin-bottom: 1rem;">No Feedback Found</h4>
            <p class="text-muted mb-4">There are no feedback entries matching your criteria.</p>
            <a href="{{ route('feedback.index') }}" style="
                background: var(--ju-blue-gradient);
                color: white;
                padding: 0.8rem 2rem;
                border-radius: var(--radius-full);
                text-decoration: none;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: var(--transition);
            ">
                <i class="fas fa-sync-alt"></i>
                Reset Filters
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Notification Container -->
<div id="notificationContainer" style="position: fixed; top: 90px; right: 20px; z-index: 9999;"></div>
@endsection

@push('scripts')
<script>
// ============================================
// NOTIFICATION SYSTEM
// ============================================
function showNotification(message, type = 'info') {
    const container = document.getElementById('notificationContainer');
    const notification = document.createElement('div');
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    notification.className = `ju-notification ju-notification-${type} animate__animated animate__fadeInRight`;
    notification.innerHTML = `
        <div class="d-flex align-items-start">
            <div class="flex-shrink-0 me-3">
                <i class="fas ${icons[type] || 'fa-info-circle'} fa-lg" style="color: ${
                    type === 'success' ? '#28a745' : 
                    type === 'error' ? '#dc3545' : 
                    type === 'warning' ? '#ffc107' : 
                    'var(--ju-blue)'
                };"></i>
            </div>
            <div class="flex-grow-1">
                <strong style="color: var(--ju-blue-dark); text-transform: uppercase; font-size: 0.8rem;">
                    ${type.charAt(0).toUpperCase() + type.slice(1)}
                </strong>
                <div style="color: var(--ju-gray-dark); margin-top: 0.2rem;">${message}</div>
            </div>
            <button class="btn-close ms-3" onclick="this.closest('.ju-notification').remove()"></button>
        </div>
    `;
    
    container.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transition = 'opacity 0.5s ease';
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 500);
    }, 5000);
}

// ============================================
// TOGGLE PUBLIC STATUS
// ============================================
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

// ============================================
// TOGGLE FEATURED STATUS
// ============================================
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

// ============================================
// DELETE FEEDBACK
// ============================================
function deleteFeedback(feedbackId) {
    event.preventDefault();
    if (confirm('⚠️ Are you sure you want to delete this feedback? This action cannot be undone.')) {
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

// ============================================
// KEYBOARD SHORTCUTS
// ============================================
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + F - Focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        document.querySelector('.ju-search-input')?.focus();
    }
    
    // Ctrl/Cmd + R - Refresh (prevent default)
    if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
        e.preventDefault();
        location.reload();
    }
    
    // Escape - Clear search
    if (e.key === 'Escape') {
        const searchInput = document.querySelector('.ju-search-input');
        if (searchInput && document.activeElement === searchInput) {
            searchInput.value = '';
            searchInput.form.submit();
        }
    }
});

// ============================================
// TOOLTIP INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    if (typeof AOS !== 'undefined') {
        AOS.refresh();
    }
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            animation: true,
            delay: { show: 100, hide: 100 }
        });
    });
    
    // Auto-refresh stats every 30 seconds (optional)
    // setInterval(() => {
    //     location.reload();
    // }, 30000);
});

// ============================================
// TABLE ROW CLICK HANDLER
// ============================================
document.querySelectorAll('.ju-feedback-row').forEach(row => {
    row.addEventListener('click', function(e) {
        if (!e.target.closest('.ju-action-btn')) {
            window.location.href = this.dataset.href;
        }
    });
});
</script>
@endpush