@extends('layouts.app')

@section('title', 'Events - Jimma University')

@section('page-title', 'Upcoming Events')
@section('page-subtitle', 'Browse all university events')

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Filters Sidebar -->
        <div class="ju-card mb-4">
            <div class="ju-card-header">
                <h6 class="ju-card-title mb-0">Filters</h6>
            </div>
            <div class="ju-card-body">
                <div class="mb-3">
                    <label class="form-label">Campus</label>
                    <select class="form-select" id="campusFilter">
                        <option value="">All Campuses</option>
                        <option value="main" {{ request('campus') == 'main' ? 'selected' : '' }}>Main Campus</option>
                        <option value="technology" {{ request('campus') == 'technology' ? 'selected' : '' }}>Technology Campus</option>
                        <option value="medical" {{ request('campus') == 'medical' ? 'selected' : '' }}>Medical Campus</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Event Type</label>
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
                
                <div class="mb-3">
                    <label class="form-label">Time Period</label>
                    <select class="form-select" id="timeFilter">
                        <option value="">All Events</option>
                        <option value="upcoming" {{ request('time') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ request('time') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="past" {{ request('time') == 'past' ? 'selected' : '' }}>Past Events</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="featuredFilter" value="1" 
                               {{ request('featured') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="featuredFilter">Featured Events Only</label>
                    </div>
                </div>
                
                <button class="btn btn-ju w-100" id="applyFilters">Apply Filters</button>
                <button class="btn btn-outline-secondary w-100 mt-2" id="resetFilters">Reset</button>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="ju-card">
            <div class="ju-card-header">
                <h6 class="ju-card-title mb-0">Quick Stats</h6>
            </div>
            <div class="ju-card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 40px; height: 40px; background: rgba(0, 100, 0, 0.1); color: var(--ju-green);">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $upcomingCount ?? 0 }}</h5>
                        <small class="text-muted">Upcoming Events</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 40px; height: 40px; background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $speakerCount ?? 0 }}</h5>
                        <small class="text-muted">Speakers</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <!-- Search Bar -->
        <div class="ju-card mb-4">
            <div class="ju-card-body">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search events by title, description, venue, or organizer..." 
                           id="searchInput" value="{{ request('search') }}">
                    <button class="btn btn-ju" type="button" id="searchButton">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Events Grid -->
        <div class="row">
            @forelse($events as $event)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="ju-card h-100">
                    @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}" 
                         style="height: 180px; object-fit: cover;">
                    @else
                    <div class="card-img-top d-flex align-items-center justify-content-center" 
                         style="height: 180px; background: var(--ju-light-green);">
                        <i class="fas fa-calendar-alt fa-3x" style="color: var(--ju-green);"></i>
                    </div>
                    @endif
                    
                    <div class="ju-card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary">{{ ucfirst($event->event_type) }}</span>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($event->start_date)->format('M d') }}</small>
                        </div>
                        
                        <h5 class="card-title">{{ Str::limit($event->title, 50) }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($event->description, 100) }}</p>
                        
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <small>{{ $event->venue }}</small>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-clock text-muted me-2"></i>
                            <small>{{ \Carbon\Carbon::parse($event->start_date)->format('h:i A') }}</small>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('events.guest.show', $event) }}" class="btn btn-sm btn-ju">
                                View Details
                            </a>
                            <button class="btn btn-sm btn-outline-secondary share-btn" 
                                    data-event-id="{{ $event->id }}"
                                    data-event-title="{{ $event->title }}">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="ju-card">
                    <div class="ju-card-body text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h4>No events found</h4>
                        <p class="text-muted">Check back later for upcoming events</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($events->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Share Link</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareLink" readonly>
                        <button class="btn btn-ju" onclick="copyToClipboard()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
                
                <div class="text-center">
                    <h6>Share via:</h6>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="btn btn-outline-primary" id="shareFacebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-info" id="shareTwitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-danger" id="shareWhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="btn btn-outline-dark" id="shareLinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        
        searchButton.addEventListener('click', function() {
            performSearch();
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        function performSearch() {
            const params = new URLSearchParams(window.location.search);
            if (searchInput.value) {
                params.set('search', searchInput.value);
            } else {
                params.delete('search');
            }
            params.delete('page');
            window.location.href = window.location.pathname + '?' + params.toString();
        }
        
        // Filter functionality
        const applyFilters = document.getElementById('applyFilters');
        const resetFilters = document.getElementById('resetFilters');
        const campusFilter = document.getElementById('campusFilter');
        const typeFilter = document.getElementById('typeFilter');
        const timeFilter = document.getElementById('timeFilter');
        const featuredFilter = document.getElementById('featuredFilter');
        
        applyFilters.addEventListener('click', function() {
            const params = new URLSearchParams();
            
            if (searchInput.value) {
                params.set('search', searchInput.value);
            }
            
            if (campusFilter.value) {
                params.set('campus', campusFilter.value);
            }
            
            if (typeFilter.value) {
                params.set('event_type', typeFilter.value);
            }
            
            if (timeFilter.value) {
                params.set('time', timeFilter.value);
            }
            
            if (featuredFilter.checked) {
                params.set('featured', '1');
            }
            
            params.delete('page');
            window.location.href = window.location.pathname + '?' + params.toString();
        });
        
        resetFilters.addEventListener('click', function() {
            window.location.href = '{{ route("events.guest.dashboard") }}';
        });
        
        // Share functionality
        const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
        const shareLink = document.getElementById('shareLink');
        
        document.querySelectorAll('.share-btn').forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.dataset.eventId;
                const eventTitle = this.dataset.eventTitle;
                const shareUrl = `{{ url('/') }}/guest/events/${eventId}`;
                
                shareLink.value = shareUrl;
                
                // Set up social sharing links
                document.getElementById('shareFacebook').href = 
                    `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`;
                document.getElementById('shareTwitter').href = 
                    `https://twitter.com/intent/tweet?text=${encodeURIComponent(eventTitle)}&url=${encodeURIComponent(shareUrl)}`;
                document.getElementById('shareWhatsApp').href = 
                    `https://wa.me/?text=${encodeURIComponent(eventTitle + ' ' + shareUrl)}`;
                document.getElementById('shareLinkedIn').href = 
                    `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl)}`;
                
                shareModal.show();
            });
        });
        
        function copyToClipboard() {
            shareLink.select();
            document.execCommand('copy');
            alert('Link copied to clipboard!');
        }
    });
</script>
@endpush