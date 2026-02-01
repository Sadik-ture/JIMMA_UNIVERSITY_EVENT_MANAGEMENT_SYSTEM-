@extends('layouts.app')

@section('title', 'Register for ' . $event->title)
@section('page-title', 'Register for Event')
@section('page-subtitle', $event->title)

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('event-registration.index') }}">Events</a></li>
    <li class="breadcrumb-item active">Register</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- Registration Header -->
            <div class="ju-card mb-4 border-primary registration-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title m-0">Event Registration</h5>
                </div>
                <div class="ju-card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <div class="rounded-circle bg-primary text-white p-3 d-inline-block">
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h3 class="mb-2">{{ $event->title }}</h3>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-primary">
                                    <i class="fas fa-calendar me-1"></i> {{ $event->start_date->format('M d, Y') }}
                                </span>
                                <span class="badge bg-secondary">
                                    <i class="fas fa-clock me-1"></i> {{ $event->start_date->format('h:i A') }}
                                </span>
                                <span class="badge bg-info">
                                    {{ ucfirst($event->event_type) }}
                                </span>
                                @if($event->max_attendees)
                                <span class="badge {{ $isFull ? 'bg-danger' : 'bg-success' }}">
                                    <i class="fas fa-users me-1"></i> 
                                    {{ $event->registered_count }}/{{ $event->max_attendees }} seats
                                    @if(!$isFull)
                                    ({{ $availableSeats }} available)
                                    @endif
                                </span>
                                @endif
                            </div>
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $event->venue }}, {{ $event->campus }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($isFull)
            <!-- Waitlist Notice -->
            <div class="ju-card mb-4 border-warning">
                <div class="ju-card-body">
                    <div class="alert alert-warning mb-0">
                        <h5><i class="fas fa-exclamation-triangle me-2"></i> Event Full</h5>
                        <p class="mb-0">This event has reached its maximum capacity. You can join the waitlist and will be notified if a seat becomes available.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Registration Form -->
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title m-0">Registration Form</h5>
                </div>
                <div class="ju-card-body">
                    <form method="POST" action="{{ route('event-registration.store', $event) }}" id="registrationForm">
                        @csrf

                        <!-- Guest Count -->
                        <div class="mb-4">
                            <label for="guest_count" class="form-label fw-bold">
                                Number of Guests (Including Yourself) *
                            </label>
                            <div class="row">
                                @for($i = 1; $i <= 5; $i++)
                                <div class="col-auto mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" 
                                               id="guest{{ $i }}" name="guest_count" value="{{ $i }}" 
                                               {{ old('guest_count', 1) == $i ? 'checked' : '' }}
                                               {{ $isFull && $i > 1 ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="guest{{ $i }}">
                                            {{ $i }} {{ $i == 1 ? 'Person' : 'People' }}
                                        </label>
                                    </div>
                                </div>
                                @endfor
                            </div>
                            @if($isFull)
                            <small class="form-text text-muted">Only individual registration available for waitlist.</small>
                            @elseif($event->max_attendees)
                            <small class="form-text text-muted">Maximum {{ min(5, $availableSeats) }} guests allowed due to limited seats.</small>
                            @else
                            <small class="form-text text-muted">Maximum 5 guests per registration.</small>
                            @endif
                            @error('guest_count')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-4">
                            <label for="additional_info" class="form-label fw-bold">
                                Additional Information (Optional)
                            </label>
                            <textarea class="form-control" id="additional_info" name="additional_info" 
                                      rows="3" placeholder="Any dietary restrictions, special needs, or additional comments...">{{ old('additional_info') }}</textarea>
                            <small class="form-text text-muted">This information will help organizers make better arrangements.</small>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('agree_terms') is-invalid @enderror" 
                                       type="checkbox" id="agree_terms" name="agree_terms" value="1" {{ old('agree_terms') ? 'checked' : '' }}>
                                <label class="form-check-label" for="agree_terms">
                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> *
                                </label>
                                @error('agree_terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('events.guest.show', $event) }}" class="btn btn-ju-outline">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            @if($isFull)
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-clock me-2"></i> Join Waitlist
                            </button>
                            @else
                            <button type="submit" class="btn btn-ju">
                                <i class="fas fa-check-circle me-2"></i> Confirm Registration
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Event Details -->
            <div class="ju-card mb-4">
                <div class="ju-card-header">
                    <h5 class="ju-card-title m-0">Event Details</h5>
                </div>
                <div class="ju-card-body">
                    <h6><i class="fas fa-info-circle text-primary me-2"></i> Description</h6>
                    <p class="mb-3">{{ $event->description }}</p>
                    
                    <h6><i class="fas fa-user-tie text-primary me-2"></i> Organizer</h6>
                    <p class="mb-3">{{ $event->organizer }}</p>
                    
                    @if($event->contact_email)
                    <h6><i class="fas fa-envelope text-primary me-2"></i> Contact Email</h6>
                    <p class="mb-3">{{ $event->contact_email }}</p>
                    @endif
                    
                    @if($event->contact_phone)
                    <h6><i class="fas fa-phone text-primary me-2"></i> Contact Phone</h6>
                    <p class="mb-0">{{ $event->contact_phone }}</p>
                    @endif
                </div>
            </div>

            <!-- Registration Tips -->
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title m-0"><i class="fas fa-lightbulb text-warning me-2"></i> Registration Tips</h5>
                </div>
                <div class="ju-card-body">
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Arrive 15 minutes before event start</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Bring your registration confirmation</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Notify organizers if you cannot attend</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Check "My Events" for updates</li>
                    </ul>
                    
                    <hr>
                    
                    @if($event->max_attendees)
                    <h6>Seat Availability</h6>
                    <div class="progress mb-3" style="height: 20px;">
                        @php
                            $percentage = ($event->registered_count / $event->max_attendees) * 100;
                        @endphp
                        <div class="progress-bar {{ $isFull ? 'bg-danger' : 'bg-success' }}" 
                             role="progressbar" style="width: {{ $percentage }}%">
                            {{ round($percentage) }}%
                        </div>
                    </div>
                    <p class="small text-muted mb-0">
                        {{ $event->registered_count }} of {{ $event->max_attendees }} seats filled
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Registration Terms</h6>
                <ol>
                    <li>Registration is required for this event.</li>
                    <li>You must be a member of Jimma University community to register.</li>
                    <li>Registration confirmation will be sent to your email.</li>
                    <li>Cancellations must be made at least 24 hours before the event.</li>
                    <li>No-shows may affect future event registration privileges.</li>
                    <li>Organizers reserve the right to cancel registrations if necessary.</li>
                    <li>By registering, you agree to follow university policies and event rules.</li>
                </ol>
                
                <h6 class="mt-4">Waitlist Policy</h6>
                <ul>
                    <li>Waitlist positions are based on first-come, first-served basis.</li>
                    <li>You will be automatically registered if a seat becomes available.</li>
                    <li>You have 24 hours to confirm when notified of available seat.</li>
                    <li>Failure to confirm will move to next person on waitlist.</li>
                </ul>
                
                <h6 class="mt-4">Cancellation Policy</h6>
                <ul>
                    <li>Cancellations are free if made 24 hours before event.</li>
                    <li>Late cancellations may affect future registration priority.</li>
                    <li>Repeated no-shows may result in registration restrictions.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ju" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Validate guest count based on available seats
        $('input[name="guest_count"]').change(function() {
            if($(this).val() > {{ $availableSeats ?? 5 }}) {
                alert('Only {{ $availableSeats }} seats available. Please select a lower number.');
                $(this).prop('checked', false);
            }
        });

        // Form validation
        $('#registrationForm').submit(function(e) {
            if(!$('#agree_terms').prop('checked')) {
                e.preventDefault();
                alert('Please agree to the terms and conditions.');
                return false;
            }
            
            const guestCount = $('input[name="guest_count"]:checked').val();
            if (!guestCount) {
                e.preventDefault();
                alert('Please select number of guests.');
                return false;
            }
        });
    });
</script>
@endpush