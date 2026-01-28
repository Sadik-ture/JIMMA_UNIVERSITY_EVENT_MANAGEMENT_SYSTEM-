@extends('layouts.app')

@section('title', 'New Event Request - JU Event Management')
@section('page-title', 'New Event Request')
@section('page-subtitle', 'Submit a new event request')

@section('content')
<div class="container-fluid">
    <div class="card ju-card">
        <div class="card-header ju-card-header">
            <h4 class="mb-0">
                <i class="fas fa-plus-circle me-2"></i>New Event Request
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('event-requests.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <!-- Event Information -->
                        <div class="card ju-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Event Information</h5>
                            </div>
                            <div class="card-body">
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
                                    <div class="col-md-6 mb-3">
                                        <label for="event_type" class="form-label">Event Type *</label>
                                        <select class="form-control @error('event_type') is-invalid @enderror" 
                                                id="event_type" name="event_type" required>
                                            <option value="">Select type</option>
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
                                    <div class="col-md-6 mb-3">
                                        <label for="expected_attendees" class="form-label">Expected Attendees</label>
                                        <input type="number" class="form-control @error('expected_attendees') is-invalid @enderror" 
                                               id="expected_attendees" name="expected_attendees" 
                                               value="{{ old('expected_attendees', 50) }}" min="1">
                                        @error('expected_attendees')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Date & Venue -->
                        <div class="card ju-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Date & Venue</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="proposed_start_date" class="form-label">Start Date *</label>
                                        <input type="date" class="form-control @error('proposed_start_date') is-invalid @enderror" 
                                               id="proposed_start_date" name="proposed_start_date" 
                                               value="{{ old('proposed_start_date') }}" required>
                                        @error('proposed_start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="proposed_end_date" class="form-label">End Date *</label>
                                        <input type="date" class="form-control @error('proposed_end_date') is-invalid @enderror" 
                                               id="proposed_end_date" name="proposed_end_date" 
                                               value="{{ old('proposed_end_date') }}" required>
                                        @error('proposed_end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="proposed_venue" class="form-label">Preferred Venue *</label>
                                        <input type="text" class="form-control @error('proposed_venue') is-invalid @enderror" 
                                               id="proposed_venue" name="proposed_venue" 
                                               value="{{ old('proposed_venue') }}" required>
                                        @error('proposed_venue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="proposed_campus" class="form-label">Campus</label>
                                        <select class="form-control @error('proposed_campus') is-invalid @enderror" 
                                                id="proposed_campus" name="proposed_campus">
                                            <option value="">Select campus</option>
                                            <option value="Main Campus" {{ old('proposed_campus') == 'Main Campus' ? 'selected' : '' }}>Main Campus</option>
                                            <option value="Technology Campus" {{ old('proposed_campus') == 'Technology Campus' ? 'selected' : '' }}>Technology Campus</option>
                                            <option value="Medical Campus" {{ old('proposed_campus') == 'Medical Campus' ? 'selected' : '' }}>Medical Campus</option>
                                        </select>
                                        @error('proposed_campus')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <!-- Organizer Information -->
                        <div class="card ju-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Organizer Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="organizer_name" class="form-label">Organizer Name *</label>
                                    <input type="text" class="form-control @error('organizer_name') is-invalid @enderror" 
                                           id="organizer_name" name="organizer_name" 
                                           value="{{ old('organizer_name', auth()->user()->name) }}" required>
                                    @error('organizer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="organizer_email" class="form-label">Organizer Email *</label>
                                    <input type="email" class="form-control @error('organizer_email') is-invalid @enderror" 
                                           id="organizer_email" name="organizer_email" 
                                           value="{{ old('organizer_email', auth()->user()->email) }}" required>
                                    @error('organizer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="organizer_phone" class="form-label">Organizer Phone</label>
                                    <input type="tel" class="form-control @error('organizer_phone') is-invalid @enderror" 
                                           id="organizer_phone" name="organizer_phone" 
                                           value="{{ old('organizer_phone') }}">
                                    @error('organizer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Requirements -->
                        <div class="card ju-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Additional Requirements</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="additional_requirements" class="form-label">Special Requirements</label>
                                    <textarea class="form-control" id="additional_requirements" 
                                              name="additional_requirements" rows="3">{{ old('additional_requirements') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="card ju-card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-ju">
                                        <i class="fas fa-paper-plane me-1"></i> Submit Request
                                    </button>
                                    <a href="{{ route('event-requests.index') }}" class="btn btn-ju-outline">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('proposed_start_date').min = today;
    document.getElementById('proposed_end_date').min = today;
});
</script>
@endpush
@endsection