@extends('layouts.app')

@section('title', 'Events Dashboard | Jimma University')
@section('page-title', 'Events Dashboard')
@section('page-subtitle', 'University Events & Activities')

@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
            <i class="fas fa-home me-2 text-success"></i>Home
        </a>
    </li>
    <li class="breadcrumb-item active">
        <span class="text-success fw-semibold">Events</span>
    </li>
@endsection

@section('content')
<style>
    :root {
        --ju-green: #006747;
        --ju-gold: #FFC72C;
        --ju-dark-green: #00573D;
        --ju-light-green: #E8F5E9;
        --ju-border: #D1E7DD;
        --ju-card-shadow: 0 3px 10px rgba(0, 103, 71, 0.08);
        --ju-card-hover: 0 8px 20px rgba(0, 103, 71, 0.15);
    }
    
    /* Fixed Header Section */
    .ju-fixed-header {
        background: linear-gradient(135deg, #006747 0%, #00573D 100%);
        padding: 20px;
        color: white;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 103, 71, 0.2);
        border-bottom: 3px solid #FFC72C;
    }
    
    .header-content {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .ju-stats {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }
    
    .ju-stat-item {
        text-align: center;
        padding: 8px 15px;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 8px;
        min-width: 90px;
        backdrop-filter: blur(5px);
    }
    
    /* Search & Filter Section */
    .search-filter-section {
        background: white;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--ju-border);
        border-radius: 10px;
        position: sticky;
        top: 120px; /* Below fixed header */
        z-index: 999;
        margin-top: 20px;
    }
    
    .search-box-container {
        position: relative;
        width: 100%;
    }
    
    .search-box-container input {
        width: 100%;
        padding: 12px 50px 12px 15px;
        border: 2px solid var(--ju-border);
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .search-box-container input:focus {
        outline: none;
        border-color: var(--ju-green);
        box-shadow: 0 0 0 3px rgba(0, 103, 71, 0.1);
    }
    
    .search-icon-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--ju-green);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .search-icon-btn:hover {
        background: var(--ju-dark-green);
    }
    
    /* Quick Filters */
    .quick-filters-container {
        display: flex;
        gap: 8px;
        margin-top: 15px;
        flex-wrap: wrap;
    }
    
    .filter-chip {
        padding: 8px 16px;
        background: white;
        border: 2px solid var(--ju-border);
        border-radius: 20px;
        color: #495057;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    
    .filter-chip:hover {
        border-color: var(--ju-green);
        color: var(--ju-green);
    }
    
    .filter-chip.active {
        background: var(--ju-green);
        color: white;
        border-color: var(--ju-green);
    }
    
    /* PERFECT EVENT CARDS - NO OVERLAPPING */
    .event-card-container {
        background: white;
        border-radius: 10px;
        height: 400px; /* Fixed height */
        transition: all 0.3s ease;
        box-shadow: var(--ju-card-shadow);
        border: 1px solid var(--ju-border);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden; /* Keep everything inside */
    }
    
    .event-card-container:hover {
        transform: translateY(-3px);
        box-shadow: var(--ju-card-hover);
        border-color: var(--ju-green);
    }
    
    /* Card Image - Fixed Height */
    .card-image-section {
        height: 130px;
        position: relative;
        flex-shrink: 0;
        background: linear-gradient(135deg, #E8F5E9 0%, #D1E7DD 100%);
    }
    
    .card-image-section img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .event-card-container:hover .card-image-section img {
        transform: scale(1.05);
    }
    
    /* Event Type Badge - Properly Positioned */
    .event-type-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 5px 10px;
        background: white;
        color: var(--ju-green);
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--ju-border);
        z-index: 2;
        max-width: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Status Badges - Properly Positioned */
    .status-badge-container {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        z-index: 2;
    }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }
    
    .featured-badge {
        background: var(--ju-gold);
        color: #000;
    }
    
    .live-badge {
        background: #DC3545;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }
    
    /* Card Body - No Overlapping */
    .card-body-content {
        padding: 15px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
        overflow: hidden; /* Prevent content from spilling out */
    }
    
    /* Event Title - Perfect Fit */
    .event-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ju-green);
        line-height: 1.3;
        margin: 0;
        height: 42px; /* Fixed height for 2 lines */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Event Description - Perfect Fit */
    .event-description {
        color: #6c757d;
        font-size: 0.85rem;
        line-height: 1.4;
        margin: 0;
        height: 40px; /* Fixed height for 2 lines */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: none; /* Don't grow */
    }
    
    /* Event Details - Clean Grid */
    .event-details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-top: 5px;
        padding: 12px;
        background: var(--ju-light-green);
        border-radius: 8px;
        border: 1px solid var(--ju-border);
        flex: none; /* Fixed height */
        min-height: 110px; /* Reserve space */
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }
    
    .detail-icon {
        width: 26px;
        height: 26px;
        background: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ju-green);
        font-size: 0.8rem;
        flex-shrink: 0;
        border: 1px solid var(--ju-border);
    }
    
    .detail-text {
        flex: 1;
        min-width: 0;
        overflow: hidden;
    }
    
    .detail-label {
        font-size: 0.65rem;
        color: #6c757d;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .detail-value {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--ju-green);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }
    
    /* Card Footer - Perfectly Positioned */
    .card-footer-section {
        padding: 12px 15px;
        background: white;
        border-top: 1px solid var(--ju-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0; /* Fixed height */
        min-height: 60px; /* Reserve space */
    }
    
    .attendance-container {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        color: #5d6d7e;
        flex: 1;
        min-width: 0;
    }
    
    .attendance-icon {
        width: 26px;
        height: 26px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ju-green);
        font-size: 0.8rem;
        border: 1px solid var(--ju-border);
        flex-shrink: 0;
    }
    
    .attendance-count {
        font-weight: 600;
        color: var(--ju-green);
    }
    
    /* View Button - Perfectly Visible */
    .view-details-button {
        padding: 8px 18px;
        background: var(--ju-green);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 3px 8px rgba(0, 103, 71, 0.15);
        white-space: nowrap;
        flex-shrink: 0;
        max-width: 120px;
        height: 36px;
        align-items: center;
        justify-content: center;
    }
    
    .view-details-button:hover {
        background: var(--ju-dark-green);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 103, 71, 0.2);
        color: white;
    }
    
    /* Grid Layout - No Overlapping */
    .events-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 10px;
    }
    
    @media (max-width: 1200px) {
        .events-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }
    }
    
    @media (max-width: 992px) {
        .events-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
    }
    
    @media (max-width: 768px) {
        .events-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .ju-fixed-header {
            padding: 15px;
        }
    }
    
    /* Empty State */
    .empty-state-container {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px 20px;
        background: white;
        border-radius: 10px;
        border: 2px dashed var(--ju-border);
        margin-top: 20px;
    }
    
    /* Results Info */
    .results-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 25px 0;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border: 1px solid var(--ju-border);
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    /* Pagination */
    .ju-pagination {
        margin-top: 30px;
        padding-bottom: 20px;
    }
    
    .ju-pagination .page-link {
        border: 1px solid var(--ju-border);
        border-radius: 6px;
        margin: 0 3px;
        color: var(--ju-green);
        font-weight: 500;
        padding: 6px 12px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    
    .ju-pagination .page-item.active .page-link {
        background: var(--ju-green);
        border-color: var(--ju-green);
        color: white;
    }
    
    /* Main Content Padding */
    .main-content {
        padding-top: 20px;
    }
</style>

<div class="container-fluid px-xl-5 px-lg-4 px-md-3">
    <!-- Fixed Header - Stays on Scroll -->
    <div class="ju-fixed-header">
        <div class="header-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-3">
                            <i class="fas fa-calendar-alt fa-2x text-white"></i>
                        </div>
                        <div>
                            <h1 class="h4 fw-bold text-white mb-1">Jimma University Events</h1>
                            <p class="text-white opacity-85 mb-0" style="font-size: 0.9rem;">
                                Discover campus activities, conferences & cultural events
                            </p>
                        </div>
                    </div>
                    
                    <div class="ju-stats">
                        <div class="ju-stat-item">
                            <div class="text-white fw-bold mb-1">{{ $upcomingCount ?? 0 }}</div>
                            <small class="opacity-75">Upcoming</small>
                        </div>
                        
                        <div class="ju-stat-item">
                            <div class="text-white fw-bold mb-1">{{ $speakerCount ?? 0 }}</div>
                            <small class="opacity-75">Speakers</small>
                        </div>
                        
                        <div class="ju-stat-item">
                            <div class="text-white fw-bold mb-1">{{ $campusCount ?? 3 }}</div>
                            <small class="opacity-75">Campuses</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <img src="{{ asset('images/calendar-illustration.svg') }}" alt="Calendar" 
                         style="height: 60px; filter: brightness(0) invert(1); opacity: 0.8;">
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="search-filter-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="search-box-container">
                    <input type="text" id="searchInput" placeholder="Search events by title, speaker, or topic..." 
                           value="{{ request('search') }}">
                    <button class="search-icon-btn" id="searchBtn">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <span class="text-muted fw-medium">
                    <i class="fas fa-filter me-1"></i>
                    {{ $events->total() }} events
                </span>
            </div>
        </div>
        
        <!-- Quick Filters -->
        <div class="quick-filters-container">
            <a href="{{ route('events.guest.dashboard') }}" 
               class="filter-chip {{ !request()->hasAny(['status', 'featured', 'event_type']) ? 'active' : '' }}">
                <i class="fas fa-globe me-1"></i>All Events
            </a>
            
            <a href="?status=upcoming" 
               class="filter-chip {{ request('status') == 'upcoming' ? 'active' : '' }}">
                <i class="fas fa-clock me-1"></i>Upcoming
            </a>
            
            <a href="?featured=1" 
               class="filter-chip {{ request('featured') == '1' ? 'active' : '' }}">
                <i class="fas fa-star me-1"></i>Featured
            </a>
            
            <a href="?status=ongoing" 
               class="filter-chip {{ request('status') == 'ongoing' ? 'active' : '' }}">
                <i class="fas fa-play-circle me-1"></i>Live Now
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Event Cards - No Overlapping -->
        <div class="events-grid">
            @forelse($events as $event)
            <div class="event-card-container">
                <!-- Card Image -->
                <div class="card-image-section">
                    @if($event->featured_image)
                    <img src="{{ asset('storage/' . $event->featured_image) }}" 
                         alt="{{ $event->title }}">
                    @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-{{ $event->event_type == 'sports' ? 'futbol' : ($event->event_type == 'cultural' ? 'music' : ($event->event_type == 'academic' ? 'graduation-cap' : 'calendar-day')) }} fa-3x" 
                           style="color: #006747; opacity: 0.2;"></i>
                    </div>
                    @endif
                    
                    <!-- Event Type Badge -->
                    <span class="event-type-badge" title="{{ ucfirst($event->event_type) }}">
                        {{ ucfirst($event->event_type) }}
                    </span>
                    
                    <!-- Status Badges -->
                    @if($event->featured)
                    <div class="status-badge-container">
                        <span class="status-badge featured-badge">
                            <i class="fas fa-star"></i> Featured
                        </span>
                    </div>
                    @endif
                    
                    @if($event->status == 'ongoing')
                    <div class="status-badge-container">
                        <span class="status-badge live-badge">
                            <i class="fas fa-play-circle"></i> Live
                        </span>
                    </div>
                    @endif
                </div>
                
                <!-- Card Body - No Overlapping -->
                <div class="card-body-content">
                    <h5 class="event-title" title="{{ $event->title }}">
                        {{ $event->title }}
                    </h5>
                    
                    <p class="event-description" title="{{ strip_tags($event->description) }}">
                        {{ Str::limit(strip_tags($event->description), 100) }}
                    </p>
                    
                    <!-- Event Details - Clear Separation -->
                    <div class="event-details-grid">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="detail-text">
                                <div class="detail-label">Date</div>
                                <div class="detail-value">{{ $event->start_date->format('M d, Y') }}</div>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="detail-text">
                                <div class="detail-label">Time</div>
                                <div class="detail-value">{{ $event->start_date->format('h:i A') }}</div>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-text">
                                <div class="detail-label">Campus</div>
                                <div class="detail-value">{{ $event->campus }}</div>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="detail-text">
                                <div class="detail-label">Attending</div>
                                <div class="detail-value">{{ $event->registered_attendees }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card Footer - Perfectly Visible -->
                <div class="card-footer-section">
                    <div class="attendance-container">
                        <div class="attendance-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <span class="attendance-count">{{ $event->registered_attendees }}</span> registered
                        </div>
                    </div>
                    
                    <a href="{{ route('events.guest.show', $event->slug) }}" 
                       class="view-details-button">
                        <i class="fas fa-eye me-1"></i>
                        View Details
                    </a>
                </div>
            </div>
            @empty
            <div class="empty-state-container">
                <i class="fas fa-calendar-times fa-3x mb-3" style="color: var(--ju-green); opacity: 0.2;"></i>
                <h4 class="mb-2" style="color: var(--ju-green);">No Events Found</h4>
                <p class="text-muted mb-3" style="font-size: 0.9rem;">Try adjusting your filters or check back later.</p>
                <a href="{{ route('events.guest.dashboard') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-redo me-2"></i>Clear Filters
                </a>
            </div>
            @endforelse
        </div>

        <!-- Results Info -->
        @if($events->count() > 0)
        <div class="results-container">
            <div>
                <span class="text-muted">
                    Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} events
                </span>
            </div>
            <div>
                <button class="btn btn-outline-success btn-sm me-2" onclick="window.print()" title="Print List">
                    <i class="fas fa-print"></i>
                </button>
                <a href="?export=1" class="btn btn-outline-primary btn-sm" title="Export Events">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>
        @endif

        <!-- Pagination -->
        @if($events->hasPages())
        <div class="ju-pagination">
            <nav aria-label="Events navigation">
                <ul class="pagination justify-content-center">
                    {{ $events->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                </ul>
            </nav>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') performSearch();
        });
        
        function performSearch() {
            const params = new URLSearchParams(window.location.search);
            if (searchInput.value.trim()) {
                params.set('search', searchInput.value.trim());
            } else {
                params.delete('search');
            }
            params.delete('page');
            window.location.href = window.location.pathname + '?' + params.toString();
        }

        // Add active class to filter chips
        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function(e) {
                if (!this.classList.contains('active')) {
                    document.querySelectorAll('.filter-chip').forEach(c => {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');
                }
            });
        });

        // Ensure no overlapping in cards
        function checkCardOverlap() {
            const cards = document.querySelectorAll('.event-card-container');
            cards.forEach(card => {
                // Check if any content is overflowing
                const body = card.querySelector('.card-body-content');
                const footer = card.querySelector('.card-footer-section');
                
                // Reset for measurement
                card.style.height = 'auto';
                
                // Calculate heights
                const imageHeight = 130;
                const bodyHeight = body.scrollHeight;
                const footerHeight = 60;
                const totalHeight = imageHeight + bodyHeight + footerHeight;
                
                // Set fixed height if needed
                if (totalHeight > 400) {
                    // Adjust description height
                    const desc = card.querySelector('.event-description');
                    desc.style.height = '36px';
                    desc.style.webkitLineClamp = 2;
                }
                
                // Set final height
                card.style.height = '400px';
            });
        }
        
        // Run on load and resize
        window.addEventListener('load', checkCardOverlap);
        window.addEventListener('resize', checkCardOverlap);
        
        // Initial check
        setTimeout(checkCardOverlap, 100);
    });
</script>
@endpush