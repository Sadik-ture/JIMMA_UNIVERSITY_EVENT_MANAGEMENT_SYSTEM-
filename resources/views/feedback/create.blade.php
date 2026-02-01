{{-- resources/views/feedback/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Submit Feedback')
@section('page-title', 'Submit Feedback')

@section('content')
<style>
    .star-rating {
        direction: rtl;
        display: inline-block;
        padding: 10px 0;
    }
    .star-rating input[type=radio] {
        display: none;
    }
    .star-rating label {
        color: #ccc;
        font-size: 2rem;
        padding: 0;
        cursor: pointer;
        transition: color 0.2s;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input[type=radio]:checked ~ label {
        color: #f0ad4e;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Feedback Form</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        
                        @if($event)
                        <div class="alert alert-info">
                            <i class="fas fa-calendar-alt me-2"></i>
                            You're providing feedback for: <strong>{{ $event->title }}</strong>
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                        </div>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Feedback Type *</label>
                                <select name="type" class="form-select" required>
                                    <option value="">Select type</option>
                                    <option value="event">Event Feedback</option>
                                    <option value="system">System Feedback</option>
                                    <option value="general">General Feedback</option>
                                    <option value="suggestion">Suggestion</option>
                                    <option value="complaint">Complaint</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Rating (Optional)</label>
                                <div class="star-rating">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                        <label for="star{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Subject (Optional)</label>
                            <input type="text" name="subject" class="form-control" placeholder="Brief subject">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Message *</label>
                            <textarea name="message" class="form-control" rows="6" 
                                      placeholder="Please provide detailed feedback..." required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Categories (Optional)</label>
                            <select name="categories[]" class="form-select" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
                        </div>
                        
                        @guest
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Your Name (Optional)</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Your Email (Optional)</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        @endguest
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="allow_contact" class="form-check-input" id="allowContact">
                                <label class="form-check-label" for="allowContact">
                                    Allow us to contact you regarding this feedback
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input type="checkbox" name="is_public" class="form-check-input" id="isPublic">
                                <label class="form-check-label" for="isPublic">
                                    Share this feedback publicly (anonymous)
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Submit Feedback
                            </button>
                            <a href="{{ route('feedback.testimonials') }}" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-star me-2"></i> View Testimonials
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection