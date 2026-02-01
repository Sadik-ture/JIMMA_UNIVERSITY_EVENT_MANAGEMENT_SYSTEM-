@extends('layouts.app')

@section('title', 'Register for Events')
@section('page-title', 'Event Registration')
@section('page-subtitle', 'Join Exciting Events at Jimma University')

@section('content')
<div class="container-fluid px-lg-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="ju-hero-card" style="background: linear-gradient(135deg, var(--ju-green) 0%, var(--ju-dark-green) 100%);">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="ju-hero-title text-white mb-3">Discover & Register for University Events</h1>
                        <p class="ju-hero-subtitle text-white-80 mb-4">
                            Join academic, cultural, sports, and social events across Jimma University campuses. 
                            Connect with peers, learn new skills, and enhance your university experience.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#events" class="btn btn-light btn-lg">
                                <i class="fas fa-calendar-alt me-2"></i> Browse Events
                            </a>
                            @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-user-plus me-2"></i> Create Account
                            </a>
                            @endguest
                        </div>
                    </div>
                    <div class="col-lg-4 text-center d-none d-lg-block">
                        <img src="{{ asset('images/event-illustration.svg') }}" alt="Events" class="img-fluid" style="max-height: 250px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    @auth
    <div class="row mb-5">
        <div class="col-12">
            <div class="ju-section-header mb-4">
                <h3 class="ju-section-title">Your Event Dashboard</h3>
                <p class="ju-section-subtitle">Track your participation and registrations</p>
            </div>
            
            <div class="row g-4">
                <div class="col-xl-3 col-lg-6">
                    <div class="ju-stat-card">
                        <div class="ju-stat-icon primary">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="ju-stat-content">
                            <h4 class="ju-stat-number">{{ auth()->user()->registrations()->confirmed()->count() }}</h4>
                            <p class="ju-stat-label">Confirmed Events</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="ju-stat-card">
                        <div class="ju-stat-icon success">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="ju-stat-content">
                            <h4 class="ju-stat-number">{{ auth()->user()->waitlists()->active()->count() }}</h4>
                            <p class="ju-stat-label">Waitlist Positions</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="ju-stat-card">
                        <div class="ju-stat-icon warning">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="ju-stat-content">
                            <h4 class="ju-stat-number">{{ auth()->user()->registrations()->attended()->count() }}</h4>
                            <p class="ju-stat-label">Events Attended</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="ju-stat-card">
                        <div class="ju-stat-card">
                            <div class="ju-stat-icon info">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="ju-stat-content">
                                <h4 class="ju-stat-number">{{ $events->total() }}</h4>
                                <p class="ju-stat-label">Available Events</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <!-- Search and Filter Section -->
    <div class="row mb-5" id="events">
        <div class="col-12">
            <div class="ju-section-header mb-4">
                <h3 class="ju-section-title">Find Your Perfect Event</h3>
                <p class="ju-section-subtitle">Filter by type, campus, or search for specific events</p>
            </div>
            
            <div class="ju-card">
                <div class="ju-card-body">
                    <form method="GET" action="{{ route('event-registration.index') }}" class="row g-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search" class="form-label fw-bold">Search Events</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="search" name="search" 
                                           value="{{ request('search') }}" placeholder="Search events...">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="event_type" class="form-label fw-bold">Event Type</label>
                                <select class="form-select form-select-lg" id="event_type" name="event_type">
                                    <option value="">All Types</option>
                                    <option value="academic" {{ request('event_type') == 'academic' ? 'selected' : '' }}>Academic</option>
                                    <option value="cultural" {{ request('event_type') == 'cultural' ? 'selected' : '' }}>Cultural</option>
                                    <option value="sports" {{ request('event_type') == 'sports' ? 'selected' : '' }}>Sports</option>
                                    <option value="conference" {{ request('event_type') == 'conference' ? 'selected' : '' }}>Conference</option>
                                    <option value="workshop" {{ request('event_type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="campus" class="form-label fw-bold">Campus</label>
                                <select class="form-select form-select-lg" id="campus" name="campus">
                                    <option value="">All Campuses</option>
                                    @foreach(\App\Models\Campus::active()->get() as $campus)
                                    <option value="{{ $campus->name }}" {{ request('campus') == $campus->name ? 'selected' : '' }}>
                                        {{ $campus->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-flex gap-2 w-100">
                                <button type="submit" class="btn btn-primary btn-lg flex-fill">
                                    <i class="fas fa-filter me-2"></i> Filter
                                </button>
                                <a href="{{ route('event-registration.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="ju-section-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="ju-section-title">Upcoming Events</h3>
                        <p class="ju-section-subtitle">{{ $events->total() }} events available for registration</p>
                    </div>
                    @auth
                    <a href="{{ route('my-events.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-calendar me-2"></i> My Events
                    </a>
                    @endauth
                </div>
            </div>
            
            @if($events->count() > 0)
            <div class="row g-4">
                @foreach($events as $event)
                <div class="col-xl-4 col-lg-6">
                    <div class="ju-event-card">
                        <div class="ju-event-card-header">
                            @if($event->image)
                            <img src="{{ Storage::url($event->image) }}" class="ju-event-image" alt="{{ $event->title }}">
                            @else
                            <div class="ju-event-image-placeholder">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            @endif
                            
                            <div class="ju-event-badges">
                                @if($event->is_featured)
                                <span class="ju-badge featured">Featured</span>
                                @endif
                                @if(in_array($event->id, $registeredEventIds))
                                <span class="ju-badge registered">Registered</span>
                                @endif
                                @if($event->is_full)
                                <span class="ju-badge full">Full</span>
                                @endif
                            </div>
                            
                            <div class="ju-event-category">
                                <span class="ju-category-badge">{{ ucfirst($event->event_type) }}</span>
                            </div>
                        </div>
                        
                        <div class="ju-event-card-body">
                            <h5 class="ju-event-title">{{ Str::limit($event->title, 60) }}</h5>
                            
                            <div class="ju-event-meta">
                                <div class="ju-event-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $event->start_date->format('M d, Y') }}</span>
                                </div>
                                <div class="ju-event-meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $event->start_date->format('h:i A') }}</span>
                                </div>
                                <div class="ju-event-meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $event->campus }}</span>
                                </div>
                            </div>
                            
                            <p class="ju-event-description">{{ Str::limit($event->description, 120) }}</p>
                            
                            <div class="ju-event-footer">
                                <div class="ju-event-availability">
                                    @if($event->max_attendees)
                                    <div class="ju-seats-progress">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Seats: {{ $event->registered_count }}/{{ $event->max_attendees }}</small>
                                            <small>
                                                @if($event->is_full)
                                                <span class="text-danger">Full</span>
                                                @else
                                                {{ $event->max_attendees - $event->registered_count }} left
                                                @endif
                                            </small>
                                        </div>
                                        <div class="progress" style="height: 6px;">
                                            @php
                                                $percentage = ($event->registered_count / $event->max_attendees) * 100;
                                            @endphp
                                            <div class="progress-bar {{ $percentage >= 90 ? 'bg-danger' : ($percentage >= 70 ? 'bg-warning' : 'bg-success') }}" 
                                                 style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="ju-event-actions">
                                    @if(auth()->check())
                                        @if(in_array($event->id, $registeredEventIds))
                                        <a href="{{ route('my-events.index') }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-check me-1"></i> Registered
                                        </a>
                                        @elseif($event->is_full)
                                        <a href="{{ route('event-registration.create', $event) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-clock me-1"></i> Join Waitlist
                                        </a>
                                        @else
                                        <a href="{{ route('event-registration.create', $event) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-user-plus me-1"></i> Register Now
                                        </a>
                                        @endif
                                    @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-sign-in-alt me-1"></i> Login to Register
                                    </a>
                                    @endif
                                    <a href="{{ route('events.guest.show', $event) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="ju-empty-state">
                <div class="ju-empty-state-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h4 class="ju-empty-state-title">No Events Available</h4>
                <p class="ju-empty-state-subtitle">Check back later for upcoming events or try different filters.</p>
                @guest
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i> Login to View More
                </a>
                @endguest
            </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
    <div class="row mb-5">
        <div class="col-12">
            <div class="ju-pagination">
                {{ $events->withQueryString()->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
    @endif

    <!-- How It Works Section -->
    @guest
    <div class="row mb-5">
        <div class="col-12">
            <div class="ju-section-header mb-4">
                <h3 class="ju-section-title">How to Register for Events</h3>
                <p class="ju-section-subtitle">Simple steps to join university events</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="ju-step-card">
                        <div class="ju-step-number">1</div>
                        <div class="ju-step-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h5 class="ju-step-title">Create Account</h5>
                        <p class="ju-step-description">Register with your Jimma University credentials</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="ju-step-card">
                        <div class="ju-step-number">2</div>
                        <div class="ju-step-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5 class="ju-step-title">Browse Events</h5>
                        <p class="ju-step-description">Find events by type, campus, or date</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="ju-step-card">
                        <div class="ju-step-number">3</div>
                        <div class="ju-step-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h5 class="ju-step-title">Register</h5>
                        <p class="ju-step-description">Click register and confirm your details</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="ju-step-card">
                        <div class="ju-step-number">4</div>
                        <div class="ju-step-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h5 class="ju-step-title">Get Confirmation</h5>
                        <p class="ju-step-description">Receive registration details and updates</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <h4 class="mb-4">Ready to Join University Events?</h4>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i> Create Account
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endguest
</div>
@endsection

@push('styles')
<style>
/* Hero Section */
.ju-hero-card {
    padding: 3rem;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.ju-hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
}

.ju-hero-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Section Headers */
.ju-section-header {
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--ju-light-green);
    margin-bottom: 2rem;
}

.ju-section-title {
    color: var(--ju-dark-green);
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.ju-section-subtitle {
    color: var(--ju-text-muted);
    font-size: 1rem;
}

/* Stat Cards */
.ju-stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
    height: 100%;
}

.ju-stat-card:hover {
    transform: translateY(-5px);
}

.ju-stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.ju-stat-icon.primary { background: linear-gradient(135deg, #667eea, #764ba2); }
.ju-stat-icon.success { background: linear-gradient(135deg, #28a745, #20c997); }
.ju-stat-icon.warning { background: linear-gradient(135deg, #ffc107, #ff9800); }
.ju-stat-icon.info { background: linear-gradient(135deg, #17a2b8, #20c997); }

.ju-stat-icon i {
    font-size: 1.5rem;
    color: white;
}

.ju-stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--ju-dark-green);
    margin: 0;
    line-height: 1;
}

.ju-stat-label {
    color: var(--ju-text-muted);
    margin: 0.25rem 0 0;
    font-size: 0.9rem;
}

/* Event Cards */
.ju-event-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid #e9ecef;
}

.ju-event-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    border-color: var(--ju-green);
}

.ju-event-card-header {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.ju-event-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.ju-event-card:hover .ju-event-image {
    transform: scale(1.05);
}

.ju-event-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--ju-green), var(--ju-dark-green));
    display: flex;
    align-items: center;
    justify-content: center;
}

.ju-event-image-placeholder i {
    font-size: 3rem;
    color: white;
    opacity: 0.8;
}

.ju-event-badges {
    position: absolute;
    top: 15px;
    left: 15px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.ju-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ju-badge.featured {
    background: linear-gradient(135deg, #ffc107, #ff9800);
}

.ju-badge.registered {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.ju-badge.full {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.ju-event-category {
    position: absolute;
    bottom: 15px;
    right: 15px;
}

.ju-category-badge {
    background: rgba(255, 255, 255, 0.95);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--ju-dark-green);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.ju-event-card-body {
    padding: 1.5rem;
}

.ju-event-title {
    font-weight: 700;
    color: var(--ju-dark-green);
    margin-bottom: 1rem;
    line-height: 1.4;
}

.ju-event-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 1rem;
}

.ju-event-meta-item {
    display: flex;
    align-items: center;
    color: var(--ju-text-muted);
    font-size: 0.9rem;
}

.ju-event-meta-item i {
    width: 20px;
    color: var(--ju-green);
    margin-right: 8px;
}

.ju-event-description {
    color: var(--ju-text-muted);
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.ju-event-footer {
    border-top: 1px solid #e9ecef;
    padding-top: 1.5rem;
}

.ju-seats-progress {
    margin-bottom: 1rem;
}

.ju-event-actions {
    display: flex;
    gap: 10px;
    justify-content: space-between;
}

/* Step Cards */
.ju-step-card {
    background: white;
    border-radius: 12px;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.ju-step-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.ju-step-number {
    width: 40px;
    height: 40px;
    background: var(--ju-green);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin: 0 auto 1rem;
}

.ju-step-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--ju-green), var(--ju-dark-green));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.ju-step-icon i {
    font-size: 1.8rem;
    color: white;
}

.ju-step-title {
    font-weight: 700;
    color: var(--ju-dark-green);
    margin-bottom: 0.5rem;
}

.ju-step-description {
    color: var(--ju-text-muted);
    font-size: 0.9rem;
    margin: 0;
}

/* Empty State */
.ju-empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.ju-empty-state-icon {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.ju-empty-state-icon i {
    font-size: 2.5rem;
    color: var(--ju-text-muted);
}

.ju-empty-state-title {
    font-weight: 700;
    color: var(--ju-dark-green);
    margin-bottom: 0.5rem;
}

.ju-empty-state-subtitle {
    color: var(--ju-text-muted);
    margin-bottom: 2rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* Pagination */
.ju-pagination {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

/* Responsive Design */
@media (max-width: 768px) {
    .ju-hero-card {
        padding: 2rem 1.5rem;
    }
    
    .ju-hero-title {
        font-size: 2rem;
    }
    
    .ju-section-header {
        text-align: center;
    }
    
    .ju-stat-card {
        padding: 1.25rem;
    }
    
    .ju-stat-icon {
        width: 50px;
        height: 50px;
    }
    
    .ju-stat-number {
        font-size: 1.75rem;
    }
}

/* Custom Variables */
:root {
    --ju-green: #1a7431;
    --ju-dark-green: #0d5b23;
    --ju-light-green: #e8f5e9;
    --ju-text-muted: #6c757d;
    --ju-card-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    --ju-transition: all 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            const hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 100
            }, 800);
        }
    });
    
    // Animate cards on scroll
    const observerOptions = {
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, observerOptions);
    
    // Observe all event cards
    document.querySelectorAll('.ju-event-card').forEach(card => {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        card.style.transition = "opacity 0.5s ease, transform 0.5s ease";
        observer.observe(card);
    });
    
    // Form validation enhancement
    $('form').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
    });
});
</script>
@endpush