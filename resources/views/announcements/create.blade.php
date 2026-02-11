@extends('layouts.app')

@section('title', 'Create Announcement - Jimma University')
@section('page-title', 'Create Announcement')
@section('page-subtitle', 'Share important updates with the university community')

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<style>
    .editor-toolbar {
        background: var(--ju-gray-100);
        border: 1px solid var(--ju-gray-300);
        border-bottom: none;
        padding: 10px;
        border-radius: var(--ju-radius-md) var(--ju-radius-md) 0 0;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .editor-content {
        min-height: 300px;
        border: 1px solid var(--ju-gray-300);
        padding: 15px;
        border-radius: 0 0 var(--ju-radius-md) var(--ju-radius-md);
        font-family: inherit;
        line-height: 1.6;
    }
    
    .audience-options {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
    }
    
    .notification-option {
        border: 2px solid var(--ju-gray-300);
        border-radius: var(--ju-radius-lg);
        padding: 20px 15px;
        text-align: center;
        cursor: pointer;
        transition: all var(--ju-transition-normal);
        background: white;
        position: relative;
        overflow: hidden;
    }
    
    .notification-option:hover {
        border-color: var(--ju-primary);
        background-color: var(--ju-primary-lighter);
        transform: translateY(-2px);
        box-shadow: var(--ju-shadow-md);
    }
    
    .notification-option.selected {
        border-color: var(--ju-primary);
        background-color: var(--ju-primary-lighter);
        box-shadow: var(--ju-shadow-sm);
    }
    
    .notification-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        color: var(--ju-primary);
        transition: all var(--ju-transition-normal);
    }
    
    .notification-option.selected .notification-icon {
        color: var(--ju-primary-dark);
        transform: scale(1.1);
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-plus-circle me-2"></i>Create New Announcement
                    </h5>
                </div>

                <div class="ju-card-body">
                    <form action="{{ route('announcements.store') }}" method="POST" id="announcementForm">
                        @csrf
                        
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                <i class="fas fa-heading me-2 text-primary"></i>Announcement Title *
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="form-control form-control-lg" 
                                   placeholder="Enter a clear and descriptive title..." 
                                   required maxlength="255"
                                   value="{{ old('title') }}">
                            <div class="char-count mt-1 text-end">
                                <span id="titleCharCount">0</span>/255 characters
                            </div>
                            @error('title')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Type Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tag me-2 text-primary"></i>Announcement Type *
                            </label>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="type-option {{ old('type', 'general') == 'general' ? 'selected' : '' }}">
                                        <input type="radio" name="type" value="general" 
                                               {{ old('type', 'general') == 'general' ? 'checked' : '' }}>
                                        <div>
                                            <i class="fas fa-bullhorn type-icon text-primary"></i>
                                            <div class="fw-semibold mt-2">General</div>
                                            <small class="text-muted">General updates</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="type-option {{ old('type') == 'event' ? 'selected' : '' }}">
                                        <input type="radio" name="type" value="event" 
                                               {{ old('type') == 'event' ? 'checked' : '' }}>
                                        <div>
                                            <i class="fas fa-calendar-alt type-icon text-info"></i>
                                            <div class="fw-semibold mt-2">Event</div>
                                            <small class="text-muted">Event announcements</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="type-option {{ old('type') == 'campus' ? 'selected' : '' }}">
                                        <input type="radio" name="type" value="campus" 
                                               {{ old('type') == 'campus' ? 'checked' : '' }}>
                                        <div>
                                            <i class="fas fa-university type-icon text-success"></i>
                                            <div class="fw-semibold mt-2">Campus</div>
                                            <small class="text-muted">Campus notices</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="type-option {{ old('type') == 'urgent' ? 'selected' : '' }}">
                                        <input type="radio" name="type" value="urgent" 
                                               {{ old('type') == 'urgent' ? 'checked' : '' }}>
                                        <div>
                                            <i class="fas fa-exclamation-triangle type-icon text-danger"></i>
                                            <div class="fw-semibold mt-2">Urgent</div>
                                            <small class="text-muted">Important alerts</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('type')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Content Editor -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">
                                <i class="fas fa-edit me-2 text-primary"></i>Announcement Content *
                            </label>
                            
                            <!-- Editor Toolbar -->
                            <div class="editor-toolbar">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="formatText('bold')" title="Bold (Ctrl+B)">
                                        <i class="fas fa-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="formatText('italic')" title="Italic (Ctrl+I)">
                                        <i class="fas fa-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="formatText('underline')" title="Underline (Ctrl+U)">
                                        <i class="fas fa-underline"></i>
                                    </button>
                                </div>
                                
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="formatText('heading', 2)" title="Heading 2">
                                        <i class="fas fa-heading"></i> H2
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="formatText('heading', 3)" title="Heading 3">
                                        <i class="fas fa-heading"></i> H3
                                    </button>
                                </div>
                                
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="insertList('ul')" title="Bullet List">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="insertList('ol')" title="Numbered List">
                                        <i class="fas fa-list-ol"></i>
                                    </button>
                                </div>
                                
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="insertLink()" title="Insert Link">
                                        <i class="fas fa-link"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="insertImage()" title="Insert Image">
                                        <i class="fas fa-image"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Content Textarea -->
                            <textarea name="content" id="content" 
                                      class="form-control editor-content" 
                                      rows="15" 
                                      placeholder="Write your announcement content here..." 
                                      required>{{ old('content') }}</textarea>
                            
                            <div class="d-flex justify-content-between mt-2">
                                <div class="char-count">
                                    <span id="contentCharCount">0</span>/5000 characters
                                </div>
                            </div>
                            
                            @error('content')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Audience Selection -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-users me-2 text-primary"></i>Target Audience *
                            </label>
                            
                            <div class="audience-options mb-4">
                                <label class="audience-option {{ old('audience', 'all') == 'all' ? 'selected' : '' }}">
                                    <input type="radio" name="audience" value="all" 
                                           {{ old('audience', 'all') == 'all' ? 'checked' : '' }}>
                                    <div>
                                        <i class="fas fa-users audience-icon"></i>
                                        <div class="audience-title">Everyone</div>
                                        <div class="audience-description">All university members</div>
                                    </div>
                                </label>
                                
                                <label class="audience-option {{ old('audience') == 'students' ? 'selected' : '' }}">
                                    <input type="radio" name="audience" value="students" 
                                           {{ old('audience') == 'students' ? 'checked' : '' }}>
                                    <div>
                                        <i class="fas fa-user-graduate audience-icon"></i>
                                        <div class="audience-title">Students Only</div>
                                        <div class="audience-description">All registered students</div>
                                    </div>
                                </label>
                                
                                <label class="audience-option {{ old('audience') == 'faculty' ? 'selected' : '' }}">
                                    <input type="radio" name="audience" value="faculty" 
                                           {{ old('audience') == 'faculty' ? 'checked' : '' }}>
                                    <div>
                                        <i class="fas fa-chalkboard-teacher audience-icon"></i>
                                        <div class="audience-title">Faculty Only</div>
                                        <div class="audience-description">Teaching staff</div>
                                    </div>
                                </label>
                                
                                <label class="audience-option {{ old('audience') == 'staff' ? 'selected' : '' }}">
                                    <input type="radio" name="audience" value="staff" 
                                           {{ old('audience') == 'staff' ? 'checked' : '' }}>
                                    <div>
                                        <i class="fas fa-user-tie audience-icon"></i>
                                        <div class="audience-title">Staff Only</div>
                                        <div class="audience-description">Administrative staff</div>
                                    </div>
                                </label>
                                
                                <label class="audience-option {{ old('audience') == 'specific' ? 'selected' : '' }}">
                                    <input type="radio" name="audience" value="specific" 
                                           {{ old('audience') == 'specific' ? 'checked' : '' }}>
                                    <div>
                                        <i class="fas fa-user-friends audience-icon"></i>
                                        <div class="audience-title">Specific Users</div>
                                        <div class="audience-description">Select individual users</div>
                                    </div>
                                </label>
                            </div>
                            
                            @error('audience')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            
                            <!-- Specific Users Selection -->
                            <div id="specificUsersSection" class="mt-4" 
                                 style="display: {{ old('audience') == 'specific' ? 'block' : 'none' }};">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="fas fa-user-check me-2"></i>Select Specific Users
                                    <small class="text-muted">(Select one or more users)</small>
                                </label>
                                
                                <div class="mb-3">
                                    <input type="text" id="userSearch" 
                                           class="form-control" 
                                           placeholder="Search users by name or email..."
                                           onkeyup="filterUsers()">
                                </div>
                                
                                <div class="target-users-list" id="usersList">
                                    @php
                                        $selectedUsers = old('target_ids', []);
                                    @endphp
                                    
                                    <!-- User Groups -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Students</h6>
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="selectGroup('students')">
                                                Select All
                                            </button>
                                        </div>
                                        @foreach($users->where('role.slug', 'student') as $user)
                                        <div class="form-check user-item" data-role="student">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="target_ids[]" value="{{ $user->id }}" 
                                                   id="user{{ $user->id }}"
                                                   {{ in_array($user->id, (array)$selectedUsers) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="user{{ $user->id }}">
                                                {{ $user->name }} 
                                                <small class="text-muted">({{ $user->email }})</small>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Faculty</h6>
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="selectGroup('faculty')">
                                                Select All
                                            </button>
                                        </div>
                                        @foreach($users->where('role.slug', 'faculty') as $user)
                                        <div class="form-check user-item" data-role="faculty">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="target_ids[]" value="{{ $user->id }}" 
                                                   id="user{{ $user->id }}"
                                                   {{ in_array($user->id, (array)$selectedUsers) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="user{{ $user->id }}">
                                                {{ $user->name }} 
                                                <small class="text-muted">({{ $user->email }})</small>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Staff</h6>
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="selectGroup('staff')">
                                                Select All
                                            </button>
                                        </div>
                                        @foreach($users->where('role.slug', 'staff') as $user)
                                        <div class="form-check user-item" data-role="staff">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="target_ids[]" value="{{ $user->id }}" 
                                                   id="user{{ $user->id }}"
                                                   {{ in_array($user->id, (array)$selectedUsers) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="user{{ $user->id }}">
                                                {{ $user->name }} 
                                                <small class="text-muted">({{ $user->email }})</small>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" 
                                            onclick="selectAllUsers()">
                                        <i class="fas fa-check-double me-1"></i>Select All Users
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" 
                                            onclick="deselectAllUsers()">
                                        <i class="fas fa-times me-1"></i>Deselect All
                                    </button>
                                </div>
                                
                                @error('target_ids')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Notification Options -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-bell me-2 text-primary"></i>Notification Settings
                            </label>
                            
                            <div class="notification-options mb-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="notification-option {{ old('send_notification', true) ? 'selected' : '' }}">
                                            <input type="radio" name="send_notification" value="1" 
                                                   {{ old('send_notification', true) ? 'checked' : '' }}>
                                            <div>
                                                <i class="fas fa-bell notification-icon"></i>
                                                <div class="fw-semibold mt-2">Send Notification</div>
                                                <div class="text-muted small">Users will receive a notification</div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="notification-option {{ !old('send_notification', true) ? 'selected' : '' }}">
                                            <input type="radio" name="send_notification" value="0" 
                                                   {{ !old('send_notification', true) ? 'checked' : '' }}>
                                            <div>
                                                <i class="fas fa-bell-slash notification-icon"></i>
                                                <div class="fw-semibold mt-2">No Notification</div>
                                                <div class="text-muted small">Announcement only, no alerts</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Advanced Notification Options -->
                            <div id="advancedNotificationOptions" style="display: {{ old('send_notification', true) ? 'block' : 'none' }};">
                                <div class="card border-info mb-3">
                                    <div class="card-header bg-info text-white">
                                        <i class="fas fa-cog me-2"></i>Advanced Notification Settings
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="notification_priority" class="form-label">
                                                        <i class="fas fa-flag me-2"></i>Notification Priority
                                                    </label>
                                                    <select name="notification_priority" id="notification_priority" class="form-select">
                                                        <option value="normal">Normal</option>
                                                        <option value="high">High</option>
                                                        <option value="urgent" {{ old('type') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="notification_type" class="form-label">
                                                        <i class="fas fa-tag me-2"></i>Notification Type
                                                    </label>
                                                    <select name="notification_type" id="notification_type" class="form-select">
                                                        <option value="announcement" selected>Announcement</option>
                                                        <option value="alert">Alert</option>
                                                        <option value="info">Information</option>
                                                        <option value="warning">Warning</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Expiration & Publishing Options -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="expires_at" class="form-label fw-semibold">
                                    <i class="fas fa-clock me-2 text-primary"></i>Expiration Date (Optional)
                                </label>
                                <input type="datetime-local" name="expires_at" id="expires_at" 
                                       class="form-control" 
                                       value="{{ old('expires_at') }}">
                                <small class="text-muted">
                                    Leave empty if the announcement should not expire
                                </small>
                                @error('expires_at')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           name="publish_now" id="publish_now" value="1"
                                           {{ old('publish_now', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="publish_now">
                                        <i class="fas fa-paper-plane me-2"></i>Publish Immediately
                                    </label>
                                    <div class="text-muted">
                                        <small>If unchecked, announcement will be saved as draft</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                            <div>
                                <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                            
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary" onclick="saveAsDraft()">
                                    <i class="fas fa-save me-2"></i>Save as Draft
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <span id="submitButtonText">
                                        {{ old('send_notification', true) ? 'Publish & Send Notification' : 'Publish Announcement' }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Preview Sidebar -->
        <div class="col-lg-4">
            <div class="ju-card preview-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-eye me-2"></i>Live Preview
                    </h5>
                </div>
                <div class="ju-card-body">
                    <div id="previewContent" class="preview-content">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-newspaper fa-3x mb-3"></i>
                            <p>Your announcement preview will appear here</p>
                        </div>
                    </div>
                </div>
                <div class="ju-card-footer">
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>The preview updates as you type. This is how your announcement will appear to users.</small>
                    </div>
                </div>
            </div>
            
            <!-- Tips Card -->
            <div class="ju-card mt-4">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-lightbulb me-2"></i>Tips for Effective Announcements
                    </h5>
                </div>
                <div class="ju-card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Clear Title:</strong> Make it descriptive and concise
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Use Formatting:</strong> Break content with headings and lists
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Be Specific:</strong> Include dates, times, and locations
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Set Audience:</strong> Target the right people
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Send Notification:</strong> Ensure users get alerted
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Handle notification option selection
document.querySelectorAll('input[name="send_notification"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Update UI for selected option
        document.querySelectorAll('.notification-option').forEach(option => {
            option.classList.remove('selected');
        });
        this.closest('.notification-option').classList.add('selected');
        
        // Show/hide advanced options
        const advancedOptions = document.getElementById('advancedNotificationOptions');
        if (this.value === '1') {
            advancedOptions.style.display = 'block';
            document.getElementById('submitButtonText').textContent = 'Publish & Send Notification';
        } else {
            advancedOptions.style.display = 'none';
            document.getElementById('submitButtonText').textContent = 'Publish Announcement';
        }
    });
});

// Handle type selection for priority
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'urgent') {
            document.getElementById('notification_priority').value = 'urgent';
        }
    });
});

// Update submit button text based on notification setting
document.addEventListener('DOMContentLoaded', function() {
    const sendNotification = document.querySelector('input[name="send_notification"]:checked');
    if (sendNotification && sendNotification.value === '0') {
        document.getElementById('submitButtonText').textContent = 'Publish Announcement';
    }
});
</script>
@endpush