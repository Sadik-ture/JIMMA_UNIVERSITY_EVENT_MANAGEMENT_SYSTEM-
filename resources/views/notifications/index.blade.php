@extends('layouts.app')

@section('title', 'My Notifications - Jimma University Events')
@section('page-title', 'My Notifications')
@section('page-subtitle', 'View your personal notifications')

@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">My Notifications</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="ju-card">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0">
                    <i class="fas fa-bell me-2"></i>My Notifications
                </h5>
                <div class="card-actions">
                    @if($unreadCount > 0)
                    <button class="btn btn-sm btn-outline-ju" onclick="markAllAsRead()">
                        <i class="fas fa-check-double me-1"></i> Mark All as Read
                    </button>
                    @endif
                </div>
            </div>
            
            <div class="ju-card-body">
                @if($notifications->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No notifications yet</h5>
                    <p class="text-muted">You will see notifications here when they are sent to you.</p>
                </div>
                @else
                <div class="notification-list">
                    @foreach($notifications as $notification)
                    @php
                        $isRead = $notification->pivot->read_at !== null;
                        $priorityClass = [
                            'low' => 'text-muted',
                            'normal' => 'text-info',
                            'high' => 'text-warning',
                            'urgent' => 'text-danger'
                        ][$notification->priority] ?? 'text-info';
                    @endphp
                    
                    <div class="notification-item mb-3 p-3 rounded border 
                        {{ $isRead ? 'bg-light' : 'bg-white border-primary' }}"
                         data-notification-id="{{ $notification->id }}">
                        <div class="d-flex align-items-start">
                            <div class="priority-indicator me-3 mt-1">
                                <i class="fas fa-bell fa-2x {{ $priorityClass }}"></i>
                            </div>
                            
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 fw-bold">{{ $notification->title }}</h6>
                                    <div class="notification-actions">
                                        @if(!$isRead)
                                        <button class="btn btn-sm btn-outline-success me-1" 
                                                onclick="markAsRead({{ $notification->id }})"
                                                title="Mark as read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @endif
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteNotification({{ $notification->id }})"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <p class="mb-2">{{ $notification->message }}</p>
                                
                                <div class="notification-meta text-muted small">
                                    <span class="me-3">
                                        <i class="fas fa-user me-1"></i>
                                        From: {{ $notification->sender->name ?? 'System' }}
                                    </span>
                                    <span class="me-3">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $notification->sent_at->diffForHumans() }}
                                    </span>
                                    @if($notification->event)
                                    <span>
                                        <i class="fas fa-calendar me-1"></i>
                                        Event: {{ $notification->event->title }}
                                    </span>
                                    @endif
                                </div>
                                
                                @if(!$isRead)
                                <div class="mt-2">
                                    <span class="badge bg-primary">NEW</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
            
            <div class="ju-card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">
                            Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} 
                            of {{ $notifications->total() }} notifications
                        </span>
                    </div>
                    <div>
                        <span class="badge bg-danger rounded-pill px-3 py-2">
                            <i class="fas fa-envelope me-1"></i>
                            {{ $unreadCount }} unread
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function markAsRead(notificationId) {
    // FIX: Use proper route with parameter
    $.ajax({
        url: '{{ route("notifications.mark-as-read", ":id") }}'.replace(':id', notificationId),
        method: 'PATCH',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                // Update the specific notification UI
                $(`[data-notification-id="${notificationId}"]`)
                    .removeClass('bg-white border-primary')
                    .addClass('bg-light')
                    .find('.badge.bg-primary').remove();
                
                // Update badge count
                updateNotificationBadge(response.unread_count);
                
                showToast('Notification marked as read', 'success');
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            showToast('Error marking notification as read', 'error');
        }
    });
}

function markAllAsRead() {
    if (!confirm('Mark all notifications as read?')) {
        return;
    }
    
    $.ajax({
        url: '{{ route("notifications.mark-all-read") }}',
        method: 'PATCH',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                // Update all notifications UI
                $('.notification-item')
                    .removeClass('bg-white border-primary')
                    .addClass('bg-light')
                    .find('.badge.bg-primary').remove();
                
                // Update badge count
                updateNotificationBadge(response.unread_count);
                
                showToast(response.message, 'success');
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            showToast('Error marking notifications as read', 'error');
        }
    });
}

function deleteNotification(notificationId) {
    if (!confirm('Delete this notification?')) {
        return;
    }
    
    // FIX: Use proper route with parameter
    $.ajax({
        url: '{{ route("notifications.destroy", ":id") }}'.replace(':id', notificationId),
        method: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                // Remove notification from UI
                $(`[data-notification-id="${notificationId}"]`).fadeOut(300, function() {
                    $(this).remove();
                    
                    // Update badge count
                    updateNotificationBadge(response.unread_count);
                    
                    showToast(response.message, 'success');
                });
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr.responseText);
            showToast('Error deleting notification', 'error');
        }
    });
}

function updateNotificationBadge(count) {
    // Update footer badge
    $('.ju-card-footer .badge').html(`<i class="fas fa-envelope me-1"></i>${count} unread`);
    
    // Update sidebar badge if exists
    const sidebarBadge = $('.notification-badge');
    if (sidebarBadge.length) {
        if (count > 0) {
            sidebarBadge.text(count).show();
        } else {
            sidebarBadge.hide();
        }
    }
}

// Add this debug function to check routes
function debugRoutes() {
    console.log('markAsRead route:', '{{ route("notifications.mark-as-read", 999) }}');
    console.log('destroy route:', '{{ route("notifications.destroy", 999) }}');
    console.log('markAllAsRead route:', '{{ route("notifications.mark-all-read") }}');
}

// Call debug on page load
$(document).ready(function() {
    debugRoutes();
});
</script>

<style>
.notification-item {
    transition: all 0.3s ease;
}

.notification-item:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0, 100, 0, 0.1);
}

.notification-actions .btn {
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.notification-item:hover .notification-actions .btn {
    opacity: 1;
}

.priority-indicator {
    flex-shrink: 0;
}
</style>
@endpush