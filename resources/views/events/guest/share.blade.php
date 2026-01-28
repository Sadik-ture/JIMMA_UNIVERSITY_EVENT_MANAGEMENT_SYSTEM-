@extends('layouts.app')

@section('title', 'Share ' . $event->title . ' - JU Event Management')
@section('page-title', 'Share Event')
@section('page-subtitle', 'Share this event with others')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('events.guest.index') }}">Events</a></li>
    <li class="breadcrumb-item"><a href="{{ route('events.guest.show', $event->slug) }}">{{ $event->title }}</a></li>
    <li class="breadcrumb-item active">Share</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="ju-card">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0"><i class="fas fa-share-alt me-2"></i>Share "{{ $event->title }}"</h5>
            </div>
            <div class="ju-card-body">
                <div class="text-center mb-5">
                    <i class="fas fa-share-square fa-5x text-success mb-4"></i>
                    <h3>Spread the Word!</h3>
                    <p class="text-muted">Share this event with friends, colleagues, or on social media.</p>
                </div>
                
                <!-- Social Media Buttons -->
                <div class="row g-3 mb-5">
                    <div class="col-md-4 col-6">
                        <a href="{{ $shareLinks['facebook'] }}" 
                           target="_blank" 
                           class="btn btn-lg btn-primary w-100 py-3">
                            <i class="fab fa-facebook-f fa-2x me-2"></i>
                            <span>Facebook</span>
                        </a>
                    </div>
                    
                    <div class="col-md-4 col-6">
                        <a href="{{ $shareLinks['twitter'] }}" 
                           target="_blank" 
                           class="btn btn-lg btn-info w-100 py-3 text-white">
                            <i class="fab fa-twitter fa-2x me-2"></i>
                            <span>Twitter</span>
                        </a>
                    </div>
                    
                    <div class="col-md-4 col-6">
                        <a href="{{ $shareLinks['linkedin'] }}" 
                           target="_blank" 
                           class="btn btn-lg btn-primary w-100 py-3">
                            <i class="fab fa-linkedin-in fa-2x me-2"></i>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                    
                    <div class="col-md-4 col-6">
                        <a href="{{ $shareLinks['whatsapp'] }}" 
                           target="_blank" 
                           class="btn btn-lg btn-success w-100 py-3">
                            <i class="fab fa-whatsapp fa-2x me-2"></i>
                            <span>WhatsApp</span>
                        </a>
                    </div>
                    
                    <div class="col-md-4 col-6">
                        <a href="{{ $shareLinks['telegram'] }}" 
                           target="_blank" 
                           class="btn btn-lg btn-info w-100 py-3">
                            <i class="fab fa-telegram fa-2x me-2"></i>
                            <span>Telegram</span>
                        </a>
                    </div>
                    
                    <div class="col-md-4 col-6">
                        <a href="{{ $shareLinks['email'] }}" 
                           class="btn btn-lg btn-danger w-100 py-3">
                            <i class="fas fa-envelope fa-2x me-2"></i>
                            <span>Email</span>
                        </a>
                    </div>
                </div>
                
                <!-- Event Preview -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Event Preview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                @if($event->featured_image)
                                <img src="{{ asset('storage/' . $event->featured_image) }}" 
                                     class="img-fluid rounded" 
                                     alt="{{ $event->title }}">
                                @else
                                <div class="bg-success bg-opacity-10 rounded p-4 text-center">
                                    <i class="fas fa-calendar-day fa-3x text-success"></i>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h5>{{ $event->title }}</h5>
                                <p class="text-muted">{{ Str::limit($event->description, 150) }}</p>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <small><i class="fas fa-calendar text-success me-1"></i> 
                                            {{ $event->start_date->format('M d, Y h:i A') }}
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small><i class="fas fa-map-marker-alt text-success me-1"></i> 
                                            {{ $event->venue }}, {{ $event->campus }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Share Link -->
                <div class="mb-4">
                    <label class="form-label">Direct Link</label>
                    <div class="input-group input-group-lg">
                        <input type="text" 
                               class="form-control" 
                               value="{{ route('events.guest.show', $event->slug) }}" 
                               readonly>
                        <button class="btn btn-ju" 
                                type="button" 
                                onclick="copyToClipboard(this)">
                            <i class="fas fa-copy me-2"></i>Copy Link
                        </button>
                    </div>
                </div>
                
                <!-- QR Code -->
                <div class="text-center mt-5">
                    <h5 class="mb-3">Scan to Share</h5>
                    <div id="qrcode" class="mb-3"></div>
                    <p class="text-muted small">Scan this QR code to quickly access the event page</p>
                </div>
            </div>
            
            <div class="ju-card-footer text-center">
                <a href="{{ route('events.guest.show', $event->slug) }}" class="btn btn-ju-outline">
                    <i class="fas fa-arrow-left me-2"></i>Back to Event
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-lg {
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    #qrcode {
        display: inline-block;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate QR Code
        const qrCodeElement = document.getElementById('qrcode');
        const eventUrl = "{{ route('events.guest.show', $event->slug) }}";
        
        QRCode.toCanvas(qrCodeElement, eventUrl, {
            width: 200,
            height: 200,
            margin: 1,
            color: {
                dark: "#006400",
                light: "#FFFFFF"
            }
        });
        
        // Copy to clipboard function
        window.copyToClipboard = function(button) {
            const input = button.closest('.input-group').querySelector('input');
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            button.classList.remove('btn-ju');
            button.classList.add('btn-success');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-ju');
            }, 2000);
        };
    });
</script>
@endpush