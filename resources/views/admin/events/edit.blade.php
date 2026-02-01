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
                        
                        <!-- Same form structure as create.blade.php but with existing values -->
                        <!-- Use $event->attribute for existing values instead of old() -->
                        <!-- Keep all the JavaScript and styling from create.blade.php -->
                        
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
                                            
                                            <!-- ... rest of the form with old('field', $event->field) for values ... -->
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- ... other cards ... -->
                            </div>
                            
                            <div class="col-lg-4">
                                <!-- Media Card with existing image -->
                                <div class="ju-sub-card mb-4">
                                    <div class="ju-sub-card-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-images me-2 text-success"></i>
                                            Event Media
                                        </h5>
                                    </div>
                                    <div class="ju-sub-card-body">
                                        @if($event->image)
                                        <div class="existing-image mb-3">
                                            <p class="small text-muted mb-2">Current Image:</p>
                                            <div class="position-relative" style="max-width: 200px;">
                                                <img src="{{ asset('storage/' . $event->image) }}" 
                                                     alt="Current event image" 
                                                     class="img-fluid rounded border">
                                                <div class="mt-2">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="removeExistingImage()">
                                                        <i class="fas fa-trash me-1"></i> Remove Image
                                                    </button>
                                                    <input type="hidden" name="remove_existing_image" id="removeExistingImage" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        @endif
                                        
                                        <!-- Image upload section (same as create) -->
                                        <div class="form-group">
                                            <label for="image" class="form-label">
                                                <i class="fas fa-image me-1 text-muted"></i>
                                                {{ $event->image ? 'Replace Image' : 'Add Image' }}
                                            </label>
                                            <!-- ... upload area (same as create) ... -->
                                        </div>
                                    </div>
                                </div>
                                <!-- ... other cards ... -->
                            </div>
                        </div>
                        
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
                                        <button type="submit" class="btn btn-warning">
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
<!-- Same styles as create.blade.php -->
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // All JavaScript from create.blade.php
        
        // Additional function for removing existing image
        function removeExistingImage() {
            if (confirm('Are you sure you want to remove the current image?')) {
                document.getElementById('removeExistingImage').value = '1';
                document.querySelector('.existing-image').style.opacity = '0.5';
                showToast('Image will be removed when you save changes', 'warning');
            }
        }
    });
</script>
@endpush