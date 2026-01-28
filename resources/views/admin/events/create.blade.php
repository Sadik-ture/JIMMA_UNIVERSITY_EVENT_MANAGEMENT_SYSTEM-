@extends('layouts.app')

@section('title', 'Create Event - Jimma University')

@section('page-title', 'Create New Event')
@section('page-subtitle', 'Add a new event to the system')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="ju-card">
    <div class="ju-card-header">
        <h5 class="ju-card-title">Event Details</h5>
    </div>
    <div class="ju-card-body">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Event Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="event_type" class="form-label">Event Type *</label>
                                <select class="form-select @error('event_type') is-invalid @enderror" 
                                        id="event_type" name="event_type" required>
                                    <option value="">Select Type</option>
                                    <option value="academic" {{ old('event_type') == 'academic' ? 'selected' : '' }}>Academic</option>
                                    <option value="cultural" {{ old('event_type') == 'cultural' ? 'selected' : '' }}>Cultural</option>
                                    <option value="sports" {{ old('event_type') == 'sports' ? 'selected' : '' }}>Sports</option>
                                    <option value="conference" {{ old('event_type') == 'conference' ? 'selected' : '' }}>Conference</option>
                                    <option value="workshop" {{ old('event_type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                    <option value="seminar" {{ old('event_type') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                                </select>
                                @error('event_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="organizer" class="form-label">Organizer *</label>
                                <input type="text" class="form-control @error('organizer') is-invalid @enderror" 
                                       id="organizer" name="organizer" value="{{ old('organizer') }}" required>
                                @error('organizer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date & Time *</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date & Time *</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="venue" class="form-label">Venue *</label>
                                <input type="text" class="form-control @error('venue') is-invalid @enderror" 
                                       id="venue" name="venue" value="{{ old('venue') }}" required>
                                @error('venue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="campus" class="form-label">Campus</label>
                                <select class="form-select @error('campus') is-invalid @enderror" id="campus" name="campus">
                                    <option value="">Select Campus</option>
                                    <option value="main" {{ old('campus') == 'main' ? 'selected' : '' }}>Main Campus</option>
                                    <option value="technology" {{ old('campus') == 'technology' ? 'selected' : '' }}>Technology Campus</option>
                                    <option value="medical" {{ old('campus') == 'medical' ? 'selected' : '' }}>Medical Campus</option>
                                </select>
                                @error('campus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Event Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <img id="imagePreview" src="#" alt="Image preview" class="img-thumbnail d-none" style="max-height: 200px;">
                        </div>
                        <small class="text-muted">Recommended size: 800x400px, Max: 2MB</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="max_attendees" class="form-label">Maximum Attendees</label>
                        <input type="number" class="form-control @error('max_attendees') is-invalid @enderror" 
                               id="max_attendees" name="max_attendees" value="{{ old('max_attendees') }}" min="1">
                        @error('max_attendees')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                               id="contact_email" name="contact_email" value="{{ old('contact_email') }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                               id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}">
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags (comma separated)</label>
                        <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                               id="tags" name="tags" value="{{ old('tags') }}" placeholder="e.g., workshop, training, seminar">
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured Event</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_public" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_public">Public Event</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="requires_registration" name="requires_registration" value="1" {{ old('requires_registration') ? 'checked' : '' }}>
                            <label class="form-check-label" for="requires_registration">Requires Registration</label>
                        </div>
                    </div>
                    
                    <div class="mb-3" id="registrationLinkField" style="{{ old('requires_registration') ? '' : 'display: none;' }}">
                        <label for="registration_link" class="form-label">Registration Link</label>
                        <input type="url" class="form-control @error('registration_link') is-invalid @enderror" 
                               id="registration_link" name="registration_link" value="{{ old('registration_link') }}" placeholder="https://...">
                        @error('registration_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-ju">
                    <i class="fas fa-save me-2"></i> Create Event
                </button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.classList.add('d-none');
            }
        });
        
        // Registration link toggle
        const requiresRegistration = document.getElementById('requires_registration');
        const registrationLinkField = document.getElementById('registrationLinkField');
        
        requiresRegistration.addEventListener('change', function() {
            if (this.checked) {
                registrationLinkField.style.display = 'block';
            } else {
                registrationLinkField.style.display = 'none';
                document.getElementById('registration_link').value = '';
            }
        });
        
        // Set min dates
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        
        // Set min to current datetime
        const now = new Date();
        const timezoneOffset = now.getTimezoneOffset() * 60000;
        const localISOTime = new Date(now - timezoneOffset).toISOString().slice(0, 16);
        
        startDateInput.min = localISOTime;
        endDateInput.min = localISOTime;
        
        // Validate end date is after start date
        startDateInput.addEventListener('change', function() {
            if (this.value) {
                endDateInput.min = this.value;
                if (endDateInput.value && endDateInput.value < this.value) {
                    alert('End date must be after start date');
                    endDateInput.value = '';
                }
            }
        });
        
        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value < startDateInput.value) {
                alert('End date must be after start date');
                this.value = '';
            }
        });
    });
</script>
@endpush