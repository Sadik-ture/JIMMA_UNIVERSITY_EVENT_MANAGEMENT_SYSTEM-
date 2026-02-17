{{-- resources/views/admin/events/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Event - Jimma University')

@section('page-title', 'Edit Event')
@section('page-subtitle', 'Update event details')

@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.events.index') }}">Events</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.events.show', $event) }}">{{ Str::limit($event->title, 20) }}</a>
    </li>
    <li class="breadcrumb-item active">Edit Event</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="ju-card shadow-sm">
                <div class="ju-card-header d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <span class="badge {{ $event->status_badge['class'] }} p-2">
                                {{ $event->status_badge['text'] }}
                            </span>
                        </div>
                        <div>
                            <h4 class="ju-card-title mb-0">
                                <i class="fas fa-calendar-edit me-2 text-warning"></i>
                                Edit Event: {{ $event->title }}
                            </h4>
                        </div>
                    </div>
                    <div class="text-muted">
                        <small>Last updated: {{ $event->updated_at->format('M d, Y') }}</small>
                    </div>
                </div>
                
                <div class="ju-card-body">
                    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" id="eventForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-lg-8">
                                <!-- Basic Information Card -->
                                <div class="ju-sub-card mb-4">
                                    <div class="ju-sub-card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-info-circle me-2 text-info"></i>
                                            Basic Information
                                        </h5>
                                    </div>
                                    <div class="ju-sub-card-body">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="title" class="form-label required">
                                                        <i class="fas fa-heading me-1 text-muted"></i>
                                                        Event Title
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                                           id="title" 
                                                           name="title" 
                                                           value="{{ old('title', $event->title) }}" 
                                                           placeholder="Enter event title..."
                                                           required>
                                                    @error('title')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="short_description" class="form-label">
                                                        <i class="fas fa-align-left me-1 text-muted"></i>
                                                        Short Description (Optional)
                                                    </label>
                                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                                              id="short_description" 
                                                              name="short_description" 
                                                              rows="2" 
                                                              placeholder="Brief summary of your event (max 200 characters)...">{{ old('short_description', $event->short_description) }}</textarea>
                                                    <div class="form-text">
                                                        <small>Brief summary that appears in event cards. Leave empty to use first 100 characters of main description.</small>
                                                    </div>
                                                    @error('short_description')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description" class="form-label required">
                                                        <i class="fas fa-align-left me-1 text-muted"></i>
                                                        Full Description
                                                    </label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                                              id="description" 
                                                              name="description" 
                                                              rows="5" 
                                                              placeholder="Describe your event in detail..."
                                                              required>{{ old('description', $event->description) }}</textarea>
                                                    <div class="form-text">
                                                        <small>Provide a clear and detailed description of your event. HTML is allowed.</small>
                                                    </div>
                                                    @error('description')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="event_type" class="form-label required">
                                                        <i class="fas fa-tag me-1 text-muted"></i>
                                                        Event Type
                                                    </label>
                                                    <select class="form-select @error('event_type') is-invalid @enderror" 
                                                            id="event_type" 
                                                            name="event_type" 
                                                            required>
                                                        <option value="">Select Event Type</option>
                                                        <option value="academic" {{ old('event_type', $event->event_type) == 'academic' ? 'selected' : '' }}>📚 Academic</option>
                                                        <option value="cultural" {{ old('event_type', $event->event_type) == 'cultural' ? 'selected' : '' }}>🎭 Cultural</option>
                                                        <option value="sports" {{ old('event_type', $event->event_type) == 'sports' ? 'selected' : '' }}>⚽ Sports</option>
                                                        <option value="conference" {{ old('event_type', $event->event_type) == 'conference' ? 'selected' : '' }}>🎤 Conference</option>
                                                        <option value="workshop" {{ old('event_type', $event->event_type) == 'workshop' ? 'selected' : '' }}>🛠️ Workshop</option>
                                                        <option value="seminar" {{ old('event_type', $event->event_type) == 'seminar' ? 'selected' : '' }}>👨‍🏫 Seminar</option>
                                                    </select>
                                                    @error('event_type')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="organizer" class="form-label required">
                                                        <i class="fas fa-users me-1 text-muted"></i>
                                                        Organizer
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control @error('organizer') is-invalid @enderror" 
                                                           id="organizer" 
                                                           name="organizer" 
                                                           value="{{ old('organizer', $event->organizer) }}" 
                                                           placeholder="Department, Club, or Organization..."
                                                           required>
                                                    @error('organizer')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date & Time Card -->
                                <div class="ju-sub-card mb-4">
                                    <div class="ju-sub-card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-clock me-2 text-warning"></i>
                                            Date & Time
                                        </h5>
                                    </div>
                                    <div class="ju-sub-card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_date" class="form-label required">
                                                        <i class="fas fa-play me-1 text-muted"></i>
                                                        Start Date & Time
                                                    </label>
                                                    <input type="datetime-local" 
                                                           class="form-control @error('start_date') is-invalid @enderror" 
                                                           id="start_date" 
                                                           name="start_date" 
                                                           value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" 
                                                           required>
                                                    @error('start_date')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date" class="form-label required">
                                                        <i class="fas fa-stop me-1 text-muted"></i>
                                                        End Date & Time
                                                    </label>
                                                    <input type="datetime-local" 
                                                           class="form-control @error('end_date') is-invalid @enderror" 
                                                           id="end_date" 
                                                           name="end_date" 
                                                           value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" 
                                                           required>
                                                    @error('end_date')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location Card -->
                                <div class="ju-sub-card mb-4">
                                    <div class="ju-sub-card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                            Location
                                        </h5>
                                    </div>
                                    <div class="ju-sub-card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="campus_id" class="form-label">
                                                        <i class="fas fa-university me-1 text-muted"></i>
                                                        Campus
                                                    </label>
                                                    <select class="form-select @error('campus_id') is-invalid @enderror" 
                                                            id="campus_id" 
                                                            name="campus_id">
                                                        <option value="">Select Campus (Optional)</option>
                                                        @foreach($campuses as $campus)
                                                            <option value="{{ $campus->id }}" 
                                                                    {{ old('campus_id', $event->campus_id) == $campus->id ? 'selected' : '' }}
                                                                    data-code="{{ $campus->code ?? '' }}">
                                                                {{ $campus->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('campus_id')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="building_id" class="form-label">
                                                        <i class="fas fa-building me-1 text-muted"></i>
                                                        Building
                                                    </label>
                                                    <select class="form-select @error('building_id') is-invalid @enderror" 
                                                            id="building_id" 
                                                            name="building_id">
                                                        <option value="">Select Building (Optional)</option>
                                                        @foreach($buildings as $building)
                                                            <option value="{{ $building->id }}" 
                                                                    {{ old('building_id', $event->building_id) == $building->id ? 'selected' : '' }}>
                                                                {{ $building->name }} {{ $building->code ? '(' . $building->code . ')' : '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('building_id')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="venue_id" class="form-label">
                                                        <i class="fas fa-door-open me-1 text-muted"></i>
                                                        Venue/Room
                                                    </label>
                                                    <select class="form-select @error('venue_id') is-invalid @enderror" 
                                                            id="venue_id" 
                                                            name="venue_id">
                                                        <option value="">Select Venue (Optional)</option>
                                                        @foreach($venues as $venue)
                                                            <option value="{{ $venue->id }}" 
                                                                    {{ old('venue_id', $event->venue_id) == $venue->id ? 'selected' : '' }}>
                                                                {{ $venue->name }} ({{ $venue->type }}, Capacity: {{ $venue->capacity }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('venue_id')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="max_attendees" class="form-label">
                                                        <i class="fas fa-users me-1 text-muted"></i>
                                                        Capacity
                                                    </label>
                                                    <input type="number" 
                                                           class="form-control @error('max_attendees') is-invalid @enderror" 
                                                           id="max_attendees" 
                                                           name="max_attendees" 
                                                           value="{{ old('max_attendees', $event->max_attendees) }}" 
                                                           min="1"
                                                           placeholder="Max attendees">
                                                    @error('max_attendees')
                                                        <div class="invalid-feedback d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle me-2"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="venue-details-card d-none p-3 bg-light rounded border">
                                                    <h6 class="mb-2">Venue Details</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <small class="text-muted d-block">Type:</small>
                                                            <span id="venue-type" class="fw-semibold">-</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted d-block">Capacity:</small>
                                                            <span id="venue-capacity" class="fw-semibold">-</span>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <small class="text-muted d-block">Amenities:</small>
                                                            <div id="venue-amenities" class="amenities-list"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Settings & Media -->
                            <div class="col-lg-4">
                                <!-- Media Card with existing image -->
                                <div class="ju-sub-card mb-4">
                                    <div class="ju-sub-card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-images me-2 text-success"></i>
                                            Event Image
                                        </h5>
                                    </div>
                                    <div class="ju-sub-card-body">
                                        @if($event->hasImage())
                                        <div class="existing-image mb-3">
                                            <p class="small text-muted mb-2">Current Image:</p>
                                            <div class="position-relative" style="max-width: 200px;">
                                                <img src="{{ $event->image_url }}" 
                                                     alt="Current event image" 
                                                     class="img-fluid rounded border">
                                                <div class="mt-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               id="remove_image" 
                                                               name="remove_image" 
                                                               value="1">
                                                        <label class="form-check-label text-danger" for="remove_image">
                                                            <i class="fas fa-trash me-1"></i> Remove Image
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        @endif
                                        
                                        <div class="form-group">
                                            <label for="image" class="form-label">
                                                <i class="fas fa-image me-1 text-muted"></i>
                                                {{ $event->hasImage() ? 'Replace Image' : 'Add Image' }}
                                            </label>
                                            <div class="image-upload-container">
                                                <div class="upload-area border rounded p-4 text-center @error('image') border-danger @enderror"
                                                     id="dropArea">
                                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                                                    <p class="mb-2">Drag & drop your image here</p>
                                                    <p class="text-muted small mb-3">or click to browse</p>
                                                    <input type="file" 
                                                           class="form-control d-none @error('image') is-invalid @enderror" 
                                                           id="image" 
                                                           name="image" 
                                                           accept="image/*">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('image').click()">
                                                        <i class="fas fa-upload me-1"></i> Choose File
                                                    </button>
                                                </div>
                                                @error('image')
                                                    <div class="invalid-feedback d-flex align-items-center mt-2">
                                                        <i class="fas fa-exclamation-circle me-2"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                
                                                <div class="image-preview mt-3 d-none" id="imagePreview">
                                                    <div class="preview-container position-relative">
                                                        <img id="previewImage" src="#" alt="Preview" class="img-fluid rounded border">
                                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" 
                                                                onclick="removeImage()">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <small class="text-muted d-block mt-2">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Recommended: 1200x600px, Max: 5MB
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information Card -->
                                <div class="ju-sub-card mb-4">
                                    <div class="ju-sub-card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-address-book me-2 text-purple"></i>
                                            Contact Information
                                        </h5>
                                    </div>
                                    <div class="ju-sub-card-body">
                                        <div class="form-group mb-3">
                                            <label for="contact_email" class="form-label">
                                                <i class="fas fa-envelope me-1 text-muted"></i>
                                                Contact Email
                                            </label>
                                            <input type="email" 
                                                   class="form-control @error('contact_email') is-invalid @enderror" 
                                                   id="contact_email" 
                                                   name="contact_email" 
                                                   value="{{ old('contact_email', $event->contact_email) }}" 
                                                   placeholder="event@ju.edu.et">
                                            @error('contact_email')
                                                <div class="invalid-feedback d-flex align-items-center">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="contact_phone" class="form-label">
                                                <i class="fas fa-phone me-1 text-muted"></i>
                                                Contact Phone
                                            </label>
                                            <input type="tel" 
                                                   class="form-control @error('contact_phone') is-invalid @enderror" 
                                                   id="contact_phone" 
                                                   name="contact_phone" 
                                                   value="{{ old('contact_phone', $event->contact_phone) }}" 
                                                   placeholder="+251 47 111 0000">
                                            @error('contact_phone')
                                                <div class="invalid-feedback d-flex align-items-center">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings Card -->
                                <div class="ju-sub-card mb-4">
                                    <div class="ju-sub-card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-cog me-2 text-secondary"></i>
                                            Event Settings
                                        </h5>
                                    </div>
                                    <div class="ju-sub-card-body">
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_featured" 
                                                   name="is_featured" 
                                                   value="1"
                                                   {{ old('is_featured', $event->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">
                                                <i class="fas fa-star me-2 text-warning"></i>
                                                Featured Event
                                            </label>
                                            <small class="text-muted d-block mt-1">
                                                Featured events appear on the homepage.
                                            </small>
                                        </div>
                                        
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_public" 
                                                   name="is_public" 
                                                   value="1"
                                                   {{ old('is_public', $event->is_public) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_public">
                                                <i class="fas fa-globe me-2 text-primary"></i>
                                                Public Event
                                            </label>
                                            <small class="text-muted d-block mt-1">
                                                Visible to all website visitors.
                                            </small>
                                        </div>
                                        
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="requires_registration" 
                                                   name="requires_registration" 
                                                   value="1"
                                                   {{ old('requires_registration', $event->requires_registration) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="requires_registration">
                                                <i class="fas fa-user-plus me-2 text-success"></i>
                                                Requires Registration
                                            </label>
                                            <small class="text-muted d-block mt-1">
                                                Attendees need to register for this event.
                                            </small>
                                        </div>
                                        
                                        <div class="registration-link-field mt-3 {{ old('requires_registration', $event->requires_registration) ? '' : 'd-none' }}" 
                                             id="registrationLinkField">
                                            <div class="form-group">
                                                <label for="registration_link" class="form-label">
                                                    <i class="fas fa-link me-1 text-muted"></i>
                                                    Registration Link
                                                </label>
                                                <input type="url" 
                                                       class="form-control @error('registration_link') is-invalid @enderror" 
                                                       id="registration_link" 
                                                       name="registration_link" 
                                                       value="{{ old('registration_link', $event->registration_link) }}" 
                                                       placeholder="https://forms.example.com/event">
                                                @error('registration_link')
                                                    <div class="invalid-feedback d-flex align-items-center">
                                                        <i class="fas fa-exclamation-circle me-2"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tags Card -->
                                <div class="ju-sub-card">
                                    <div class="ju-sub-card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-tags me-2 text-orange"></i>
                                            Tags & Categories
                                        </h5>
                                    </div>
                                    <div class="ju-sub-card-body">
                                        <div class="form-group">
                                            <label for="tags" class="form-label">
                                                <i class="fas fa-hashtag me-1 text-muted"></i>
                                                Event Tags
                                            </label>
                                            @php
                                                $tagsValue = '';
                                                if ($event->tags && is_array($event->tags)) {
                                                    $tagsValue = implode(', ', $event->tags);
                                                } elseif (is_string($event->tags)) {
                                                    $tagsValue = $event->tags;
                                                }
                                            @endphp
                                            <input type="text" 
                                                   class="form-control @error('tags') is-invalid @enderror" 
                                                   id="tags" 
                                                   name="tags" 
                                                   value="{{ old('tags', $tagsValue) }}" 
                                                   placeholder="workshop, training, seminar, technology">
                                            <small class="text-muted d-block mt-1">
                                                Separate tags with commas (max 10 tags).
                                            </small>
                                            @error('tags')
                                                <div class="invalid-feedback d-flex align-items-center">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            
                                            <div class="tag-suggestions mt-3">
                                                <small class="text-muted d-block mb-2">Suggested tags:</small>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge bg-light text-dark cursor-pointer tag-suggestion">
                                                        academic
                                                    </span>
                                                    <span class="badge bg-light text-dark cursor-pointer tag-suggestion">
                                                        workshop
                                                    </span>
                                                    <span class="badge bg-light text-dark cursor-pointer tag-suggestion">
                                                        seminar
                                                    </span>
                                                    <span class="badge bg-light text-dark cursor-pointer tag-suggestion">
                                                        conference
                                                    </span>
                                                    <span class="badge bg-light text-dark cursor-pointer tag-suggestion">
                                                        cultural
                                                    </span>
                                                    <span class="badge bg-light text-dark cursor-pointer tag-suggestion">
                                                        sports
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Speaker Assignment Section -->
                     @include('admin.events.partials.speaker-assignment') 

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded border">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            Fields marked with <span class="text-danger">*</span> are required.
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.events.show', $event) }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-2"></i>
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-ju-primary">
                                            <i class="fas fa-save me-2"></i>
                                            Update Event
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: #dc3545;
    }
    
    .ju-sub-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .ju-sub-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .ju-sub-card-body {
        padding: 20px;
    }
    
    .btn-ju-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-ju-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-outline-ju-primary {
        border: 2px solid #667eea;
        color: #667eea;
        background: transparent;
        padding: 0.5rem 1.5rem;
    }
    
    .btn-outline-ju-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
    }
    
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .upload-area:hover {
        border-color: #667eea;
        background-color: rgba(102, 126, 234, 0.05);
    }
    
    .upload-area.dragover {
        border-color: #667eea;
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    .image-preview img {
        max-height: 200px;
        object-fit: cover;
    }
    
    .amenities-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }
    
    .amenity-badge {
        font-size: 11px;
        padding: 2px 8px;
    }
    
    .tag-suggestion {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .tag-suggestion:hover {
        background-color: #667eea !important;
        color: white !important;
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    .preview-container {
        position: relative;
        max-width: 300px;
        margin: 0 auto;
    }
    
    .preview-container .btn {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image upload with drag & drop
        const dropArea = document.getElementById('dropArea');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('dragover');
        }
        
        function unhighlight() {
            dropArea.classList.remove('dragover');
        }
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        imageInput.addEventListener('change', function() {
            handleFiles(this.files);
        });
        
        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                    imageInput.files = files;
                } else {
                    alert('Please select an image file.');
                }
            }
        }
        
        // Campus, Building, Venue cascading dropdowns
        const campusSelect = document.getElementById('campus_id');
        const buildingSelect = document.getElementById('building_id');
        const venueSelect = document.getElementById('venue_id');
        const venueDetailsCard = document.querySelector('.venue-details-card');
        const maxAttendeesInput = document.getElementById('max_attendees');
        
        campusSelect.addEventListener('change', function() {
            const campusId = this.value;
            
            if (campusId) {
                // Load buildings for selected campus
                fetch(`/admin/events/get-buildings/${campusId}`)
                    .then(response => response.json())
                    .then(data => {
                        buildingSelect.innerHTML = '<option value="">Select Building (Optional)</option>';
                        data.forEach(building => {
                            const option = document.createElement('option');
                            option.value = building.id;
                            option.textContent = `${building.name} ${building.code ? `(${building.code})` : ''}`;
                            buildingSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading buildings:', error));
            }
        });
        
        buildingSelect.addEventListener('change', function() {
            const buildingId = this.value;
            
            if (buildingId) {
                // Load venues for selected building
                fetch(`/admin/events/get-venues/${buildingId}`)
                    .then(response => response.json())
                    .then(data => {
                        venueSelect.innerHTML = '<option value="">Select Venue (Optional)</option>';
                        data.forEach(venue => {
                            const option = document.createElement('option');
                            option.value = venue.id;
                            option.textContent = `${venue.name} (${venue.type}, Capacity: ${venue.capacity})`;
                            venueSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading venues:', error));
            }
        });
        
        venueSelect.addEventListener('change', function() {
            const venueId = this.value;
            
            if (venueId) {
                // Load venue details
                fetch(`/admin/events/get-venue-details/${venueId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update venue details card
                        document.getElementById('venue-type').textContent = data.type;
                        document.getElementById('venue-capacity').textContent = data.capacity;
                        
                        // Update max attendees input with venue capacity
                        if (!maxAttendeesInput.value || parseInt(maxAttendeesInput.value) > data.capacity) {
                            maxAttendeesInput.value = data.capacity;
                            maxAttendeesInput.max = data.capacity;
                        }
                        
                        // Show amenities
                        const amenitiesList = document.getElementById('venue-amenities');
                        amenitiesList.innerHTML = '';
                        
                        if (data.amenities && data.amenities.length > 0) {
                            data.amenities.forEach(amenity => {
                                const badge = document.createElement('span');
                                badge.className = 'badge bg-light text-dark amenity-badge me-1 mb-1';
                                badge.textContent = amenity;
                                amenitiesList.appendChild(badge);
                            });
                        } else {
                            amenitiesList.innerHTML = '<span class="text-muted">No amenities listed</span>';
                        }
                        
                        venueDetailsCard.classList.remove('d-none');
                    })
                    .catch(error => console.error('Error loading venue details:', error));
            } else {
                venueDetailsCard.classList.add('d-none');
            }
        });
        
        // Registration link toggle
        const requiresRegistration = document.getElementById('requires_registration');
        const registrationLinkField = document.getElementById('registrationLinkField');
        
        requiresRegistration.addEventListener('change', function() {
            if (this.checked) {
                registrationLinkField.classList.remove('d-none');
            } else {
                registrationLinkField.classList.add('d-none');
                document.getElementById('registration_link').value = '';
            }
        });
        
        // Date validation
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        startDateInput.addEventListener('change', function() {
            if (this.value) {
                endDateInput.min = this.value;
                if (endDateInput.value && endDateInput.value < this.value) {
                    showToast('End date must be after start date', 'warning');
                    endDateInput.value = '';
                }
            }
        });
        
        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value < startDateInput.value) {
                showToast('End date must be after start date', 'warning');
                this.value = '';
            }
        });
        
        // Tag suggestions
        document.querySelectorAll('.tag-suggestion').forEach(tag => {
            tag.addEventListener('click', function() {
                const tagsInput = document.getElementById('tags');
                const currentTags = tagsInput.value ? tagsInput.value.split(',').map(t => t.trim()) : [];
                const newTag = this.textContent.trim();
                
                if (!currentTags.includes(newTag)) {
                    if (currentTags.length >= 10) {
                        showToast('Maximum 10 tags allowed', 'warning');
                        return;
                    }
                    
                    currentTags.push(newTag);
                    tagsInput.value = currentTags.join(', ');
                }
            });
        });
        
        // Form validation
        const form = document.getElementById('eventForm');
        form.addEventListener('submit', function(e) {
            // Validate dates
            if (startDateInput.value && endDateInput.value) {
                const start = new Date(startDateInput.value);
                const end = new Date(endDateInput.value);
                
                if (end <= start) {
                    e.preventDefault();
                    showToast('End date must be after start date', 'error');
                    return;
                }
            }
            
            // Validate max attendees if venue is selected
            if (venueSelect.value && maxAttendeesInput.value) {
                const venueCapacity = parseInt(document.getElementById('venue-capacity').textContent);
                const maxAttendees = parseInt(maxAttendeesInput.value);
                
                if (maxAttendees > venueCapacity) {
                    e.preventDefault();
                    showToast(`Maximum attendees cannot exceed venue capacity (${venueCapacity})`, 'error');
                    return;
                }
            }
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Updating...';
            submitBtn.disabled = true;
        });
        
        // Helper functions
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.style.minWidth = '300px';
            toast.innerHTML = `
                <strong>${type === 'error' ? 'Error' : type === 'warning' ? 'Warning' : 'Info'}!</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
        
        function removeImage() {
            imagePreview.classList.add('d-none');
            previewImage.src = '#';
            imageInput.value = '';
        }
        
        // If there's an image preview from form error, show it
        @if(old('image_preview'))
            previewImage.src = "{{ old('image_preview') }}";
            imagePreview.classList.remove('d-none');
        @endif
    });
</script>
@endpush