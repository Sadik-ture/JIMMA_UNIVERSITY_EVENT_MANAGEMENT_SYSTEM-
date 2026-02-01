@extends('layouts.app')

@section('title', 'Share ' . $event->title . ' - Jimma University')
@section('page-title', 'Share Event')
@section('page-subtitle', 'Spread the word about this event')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('events.guest.dashboard') }}">Events</a></li>
    <li class="breadcrumb-item"><a href="{{ route('events.guest.show', $event->slug) }}">{{ Str::limit($event->title, 20) }}</a></li>
    <li class="breadcrumb-item active">Share</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-success text-white py-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-share-alt fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h2 class="mb-0">Share this Event</h2>
                        <p class="mb-0 opacity-75">Help spread the word about this event</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Event Preview -->
                <div class="row align-items-center mb-5">
                    <div class="col-md-3">
                        @if($event->featured_image)
                        <img src="{{ asset('storage/' . $event->featured_image) }}" 
                             class="img-fluid rounded shadow-sm" 
                             alt="{{ $event->title }}">
                        @else
                        <div class="bg-success bg-opacity-10 rounded d-flex align-items-center justify-content-center" 
                             style="height: 180px;">
                            <i class="fas fa-calendar-day fa-4x text-success opacity-50"></i>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <h3 class="mb-2">{{ $event->title }}</h3>
                        <p class="text-muted mb-3">{{ Str::limit($event->description, 200) }}</p>
                        
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-calendar text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Date</small>
                                        <strong>{{ $event->start_date->format('F d, Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-clock text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Time</small>
                                        <strong>{{ $event->start_date->format('h:i A') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-map-marker-alt text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Venue</small>
                                        <strong>{{ $event->venue }}, {{ $event->campus }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-users text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Attendees</small>
                                        <strong>{{ $event->registered_attendees }} registered</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Sharing Buttons -->
                <div class="text-center mb-5">
                    <h4 class="mb-4">Share on Social Media</h4>
                    <div class="row g-3 justify-content-center">
                        @foreach($shareLinks as $platform => $link)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ $link }}" 
                               target="_blank" 
                               class="btn btn-lg w-100 py-3 btn-share btn-share-{{ $platform }}"
                               data-platform="{{ $platform }}">
                                <i class="fab fa-{{ $platform }} fa-2x mb-2"></i>
                                <br>
                                <span class="small">{{ ucfirst($platform) }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Share Options -->
                <div class="row g-4 mb-5">
                    <!-- Direct Link -->
                    <div class="col-md-6">
                        <div class="card border h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-link text-success me-2"></i>Direct Link
                                </h5>
                                <p class="text-muted small mb-3">Copy this link to share anywhere</p>
                                
                                <div class="input-group input-group-lg mb-3">
                                    <input type="text" 
                                           class="form-control" 
                                           value="{{ route('events.guest.show', $event->slug) }}" 
                                           id="eventLink"
                                           readonly>
                                    <button class="btn btn-success" 
                                            type="button"
                                            onclick="copyToClipboard('eventLink')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                
                                <div class="d-grid">
                                    <button class="btn btn-outline-success" 
                                            onclick="shareViaEmail()">
                                        <i class="fas fa-envelope me-2"></i>Share via Email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="col-md-6">
                        <div class="card border h-100">
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    <i class="fas fa-qrcode text-success me-2"></i>QR Code
                                </h5>
                                <p class="text-muted small mb-3">Scan to view event details</p>
                                
                                <div id="qrCode" class="mb-3"></div>
                                
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-outline-success btn-sm" onclick="downloadQRCode()">
                                        <i class="fas fa-download me-2"></i>Download
                                    </button>
                                    <button class="btn btn-outline-success btn-sm" onclick="printQRCode()">
                                        <i class="fas fa-print me-2"></i>Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Embed Code -->
                    <div class="col-12">
                        <div class="card border">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="fas fa-code text-success me-2"></i>Embed on Website
                                </h5>
                                <p class="text-muted small mb-3">Add this event to your website or blog</p>
                                
                                <div class="input-group mb-3">
                                    <textarea class="form-control font-monospace small" 
                                              rows="4"
                                              id="embedCode"
                                              readonly><iframe src="{{ route('events.embed', $event->slug) }}" width="100%" height="400" frameborder="0" style="border:0"></iframe></textarea>
                                    <button class="btn btn-success" 
                                            type="button"
                                            onclick="copyToClipboard('embedCode')">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                                
                                <div class="alert alert-info small mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    This embed code will display event details on your website
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share Statistics -->
                <div class="card border">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-chart-bar text-success me-2"></i>Share Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-6 mb-3">
                                <div class="display-5 fw-bold text-success">{{ $event->shares_count ?? 0 }}</div>
                                <small class="text-muted">Total Shares</small>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="display-5 fw-bold text-success">{{ $event->views_count ?? 0 }}</div>
                                <small class="text-muted">Total Views</small>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="display-5 fw-bold text-success">{{ $event->registered_attendees }}</div>
                                <small class="text-muted">Registered</small>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="display-5 fw-bold text-success">
                                    @if($event->max_attendees)
                                        {{ round(($event->registered_attendees / $event->max_attendees) * 100) }}%
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <small class="text-muted">Capacity Filled</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light border-0 py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('events.guest.show', $event->slug) }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left me-2"></i>Back to Event
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('events.export.ics', $event->slug) }}" class="btn btn-success">
                            <i class="fas fa-calendar-plus me-2"></i>Add to Calendar
                        </a>
                        <a href="{{ route('events.guest.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-calendar-alt me-2"></i>Browse More Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-share {
        border-radius: 12px;
        transition: all 0.3s ease;
        color: white;
        border: none;
    }

    .btn-share:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-share-facebook { background: #3b5998; }
    .btn-share-twitter { background: #1da1f2; }
    .btn-share-linkedin { background: #0077b5; }
    .btn-share-whatsapp { background: #25d366; }
    .btn-share-telegram { background: #0088cc; }
    .btn-share-email { background: #ea4335; }
    .btn-share-messenger { background: #0084ff; }
    .btn-share-reddit { background: #ff4500; }

    .btn-share:hover {
        opacity: 0.9;
    }

    #qrCode {
        display: inline-block;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .font-monospace {
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate QR Code
        const qrCodeElement = document.getElementById('qrCode');
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

        // Track social shares
        document.querySelectorAll('.btn-share').forEach(button => {
            button.addEventListener('click', function() {
                const platform = this.dataset.platform;
                trackShare(platform);
            });
        });
    });

    // Copy to clipboard function
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        element.setSelectionRange(0, 99999);
        document.execCommand('copy');
        
        showToast('Copied to clipboard!', 'success');
    }

    // Share via email
    function shareViaEmail() {
        const subject = "Check out this event: {{ $event->title }}";
        const body = `I thought you might be interested in this event:\n\n` +
                     `Title: {{ $event->title }}\n` +
                     `Date: {{ $event->start_date->format('F d, Y') }}\n` +
                     `Time: {{ $event->start_date->format('h:i A') }}\n` +
                     `Venue: {{ $event->venue }}, {{ $event->campus }}\n` +
                     `Description: {{ Str::limit($event->description, 200) }}\n\n` +
                     `View details: {{ route('events.guest.show', $event->slug) }}`;
        
        window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        
        trackShare('email');
    }

    // Download QR Code
    function downloadQRCode() {
        const canvas = document.querySelector('#qrCode canvas');
        const link = document.createElement('a');
        link.download = 'event-qr-code.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
        
        showToast('QR Code downloaded!', 'success');
    }

    // Print QR Code
    function printQRCode() {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>QR Code - {{ $event->title }}</title>
                    <style>
                        body { text-align: center; padding: 50px; }
                        h3 { margin-bottom: 30px; }
                        canvas { margin: 20px 0; }
                    </style>
                </head>
                <body>
                    <h3>{{ $event->title }}</h3>
                    <p>Scan to view event details</p>
                    <div id="printQR"></div>
                    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"><\/script>
                    <script>
                        QRCode.toCanvas(document.getElementById('printQR'), "{{ route('events.guest.show', $event->slug) }}", {
                            width: 300,
                            height: 300,
                            margin: 1,
                            color: { dark: "#000000", light: "#FFFFFF" }
                        });
                        setTimeout(() => { window.print(); window.close(); }, 500);
                    <\/script>
                </body>
            </html>
        `);
        printWindow.document.close();
    }

    // Track share in database
    function trackShare(platform) {
        fetch('{{ route("events.track.share", $event->slug) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ platform: platform })
        });
    }

    // Toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
</script>
@endpush