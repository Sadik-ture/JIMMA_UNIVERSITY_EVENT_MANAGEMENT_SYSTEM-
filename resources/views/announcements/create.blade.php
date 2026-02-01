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
    
    .editor-content:focus {
        outline: none;
        border-color: var(--ju-primary);
        box-shadow: 0 0 0 3px rgba(0, 100, 0, 0.1);
    }
    
    .audience-options {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
    }
    
    .audience-option {
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
    
    .audience-option:hover {
        border-color: var(--ju-primary);
        background-color: var(--ju-primary-lighter);
        transform: translateY(-2px);
        box-shadow: var(--ju-shadow-md);
    }
    
    .audience-option.selected {
        border-color: var(--ju-primary);
        background-color: var(--ju-primary-lighter);
        box-shadow: var(--ju-shadow-sm);
    }
    
    .audience-option input[type="radio"] {
        display: none;
    }
    
    .audience-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        color: var(--ju-primary);
        transition: all var(--ju-transition-normal);
    }
    
    .audience-option.selected .audience-icon {
        color: var(--ju-primary-dark);
        transform: scale(1.1);
    }
    
    .audience-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--ju-gray-800);
    }
    
    .audience-description {
        font-size: 0.85rem;
        color: var(--ju-gray-600);
    }
    
    .target-users-list {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid var(--ju-gray-300);
        border-radius: var(--ju-radius-md);
        padding: 15px;
        background: white;
    }
    
    .type-option {
        border: 2px solid var(--ju-gray-300);
        border-radius: var(--ju-radius-md);
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: all var(--ju-transition-normal);
    }
    
    .type-option:hover {
        border-color: var(--ju-primary);
        transform: translateY(-2px);
    }
    
    .type-option.selected {
        border-color: var(--ju-primary);
        background-color: var(--ju-primary-lighter);
    }
    
    .type-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    
    .preview-card {
        position: sticky;
        top: 20px;
    }
    
    .char-count {
        font-size: 0.85rem;
        color: var(--ju-gray-600);
    }
    
    .char-count.warning {
        color: var(--ju-warning);
    }
    
    .char-count.danger {
        color: var(--ju-danger);
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
                                
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="clearFormat()" title="Clear Formatting">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" 
                                            onclick="previewContent()" title="Preview">
                                        <i class="fas fa-eye"></i>
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
                                <div>
                                    <small class="text-muted">
                                        Supports: <strong>Bold</strong>, <em>Italic</em>, Lists, Links
                                    </small>
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
                                           {{ old('publish_now') ? 'checked' : '' }}>
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
                                    <i class="fas fa-paper-plane me-2"></i>Publish Announcement
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
                            <strong>Set Expiry:</strong> Remove outdated announcements
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ju-card">
            <div class="modal-header ju-card-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Announcement Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body ju-card-body">
                <div id="modalPreviewContent"></div>
            </div>
            <div class="modal-footer ju-card-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('announcementForm').submit()">
                    <i class="fas fa-paper-plane me-2"></i>Publish Now
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize character counters
document.getElementById('title').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('titleCharCount').textContent = count;
    
    const charCount = document.querySelector('#titleCharCount').parentElement;
    charCount.className = 'char-count mt-1 text-end';
    
    if (count > 200) {
        charCount.classList.add('warning');
    }
    if (count >= 255) {
        charCount.classList.add('danger');
    }
});

document.getElementById('content').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('contentCharCount').textContent = count;
    
    const charCount = document.querySelector('#contentCharCount').parentElement;
    charCount.className = 'char-count';
    
    if (count > 4000) {
        charCount.classList.add('warning');
    }
    if (count >= 5000) {
        charCount.classList.add('danger');
    }
    
    // Update preview
    updatePreview();
});

// Initialize counters on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('title').dispatchEvent(new Event('input'));
    document.getElementById('content').dispatchEvent(new Event('input'));
    
    // Set minimum datetime for expiration (current time)
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('expires_at').min = now.toISOString().slice(0, 16);
    
    // Set default expiry to 7 days from now
    const defaultExpiry = new Date(now);
    defaultExpiry.setDate(defaultExpiry.getDate() + 7);
    if (!document.getElementById('expires_at').value) {
        document.getElementById('expires_at').value = defaultExpiry.toISOString().slice(0, 16);
    }
});

// Handle audience selection
document.querySelectorAll('input[name="audience"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Update UI for selected option
        document.querySelectorAll('.audience-option').forEach(option => {
            option.classList.remove('selected');
        });
        this.closest('.audience-option').classList.add('selected');
        
        // Show/hide specific users section
        const specificUsersSection = document.getElementById('specificUsersSection');
        if (this.value === 'specific') {
            specificUsersSection.style.display = 'block';
        } else {
            specificUsersSection.style.display = 'none';
        }
    });
});

// Handle type selection
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.type-option').forEach(option => {
            option.classList.remove('selected');
        });
        this.closest('.type-option').classList.add('selected');
    });
});

// User selection functions
function selectAllUsers() {
    document.querySelectorAll('input[name="target_ids[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllUsers() {
    document.querySelectorAll('input[name="target_ids[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}

function selectGroup(group) {
    document.querySelectorAll(`.user-item[data-role="${group}"] input`).forEach(checkbox => {
        checkbox.checked = true;
    });
}

function filterUsers() {
    const searchTerm = document.getElementById('userSearch').value.toLowerCase();
    document.querySelectorAll('.user-item').forEach(item => {
        const label = item.querySelector('.form-check-label').textContent.toLowerCase();
        item.style.display = label.includes(searchTerm) ? 'block' : 'none';
    });
}

// Editor functions
function formatText(command, param = null) {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    let formattedText = selectedText;
    
    switch(command) {
        case 'bold':
            formattedText = `<strong>${selectedText}</strong>`;
            break;
        case 'italic':
            formattedText = `<em>${selectedText}</em>`;
            break;
        case 'underline':
            formattedText = `<u>${selectedText}</u>`;
            break;
        case 'heading':
            formattedText = `<h${param}>${selectedText}</h${param}>`;
            break;
    }
    
    textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
    textarea.focus();
    textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
    
    // Trigger input event for preview update
    textarea.dispatchEvent(new Event('input'));
}

function insertList(type) {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    
    let list = '';
    if (type === 'ul') {
        list = '<ul>\n  <li>First item</li>\n  <li>Second item</li>\n  <li>Third item</li>\n</ul>';
    } else {
        list = '<ol>\n  <li>First item</li>\n  <li>Second item</li>\n  <li>Third item</li>\n</ol>';
    }
    
    textarea.value = textarea.value.substring(0, start) + '\n' + list + '\n' + textarea.value.substring(start);
    textarea.focus();
    textarea.setSelectionRange(start + list.length + 2, start + list.length + 2);
    textarea.dispatchEvent(new Event('input'));
}

function insertLink() {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end) || 'Link Text';
    
    const url = prompt('Enter URL:', 'https://');
    if (url) {
        const link = `<a href="${url}" target="_blank">${selectedText}</a>`;
        textarea.value = textarea.value.substring(0, start) + link + textarea.value.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + link.length, start + link.length);
        textarea.dispatchEvent(new Event('input'));
    }
}

function insertImage() {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    
    const url = prompt('Enter image URL:', 'https://');
    if (url) {
        const alt = prompt('Enter image description:', '');
        const image = `<img src="${url}" alt="${alt}" style="max-width: 100%; height: auto;">`;
        textarea.value = textarea.value.substring(0, start) + '\n' + image + '\n' + textarea.value.substring(start);
        textarea.focus();
        textarea.setSelectionRange(start + image.length + 2, start + image.length + 2);
        textarea.dispatchEvent(new Event('input'));
    }
}

function clearFormat() {
    const textarea = document.getElementById('content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    // Remove HTML tags but keep line breaks
    const plainText = selectedText.replace(/<[^>]*>/g, '');
    
    textarea.value = textarea.value.substring(0, start) + plainText + textarea.value.substring(end);
    textarea.focus();
    textarea.setSelectionRange(start + plainText.length, start + plainText.length);
    textarea.dispatchEvent(new Event('input'));
}

// Preview functions
function updatePreview() {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    const type = document.querySelector('input[name="type"]:checked')?.value || 'general';
    
    const previewDiv = document.getElementById('previewContent');
    
    if (!title.trim() && !content.trim()) {
        previewDiv.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="fas fa-newspaper fa-3x mb-3"></i>
                <p>Your announcement preview will appear here</p>
            </div>
        `;
        return;
    }
    
    const typeIcons = {
        'general': 'bullhorn',
        'event': 'calendar-alt',
        'campus': 'university',
        'urgent': 'exclamation-triangle'
    };
    
    const typeColors = {
        'general': 'primary',
        'event': 'info',
        'campus': 'success',
        'urgent': 'danger'
    };
    
    const typeLabels = {
        'general': 'General Announcement',
        'event': 'Event Notice',
        'campus': 'Campus Update',
        'urgent': 'Urgent Notice'
    };
    
    previewDiv.innerHTML = `
        <div class="preview-header mb-4">
            <div class="d-flex align-items-center mb-3">
                <div class="me-3">
                    <i class="fas fa-${typeIcons[type]} fa-2x text-${typeColors[type]}"></i>
                </div>
                <div>
                    <span class="badge bg-${typeColors[type]}">${typeLabels[type]}</span>
                    <small class="text-muted ms-2">
                        <i class="far fa-clock me-1"></i>Just now
                    </small>
                </div>
            </div>
            
            <h4 class="preview-title mb-3">${title || 'Untitled Announcement'}</h4>
        </div>
        
        <div class="preview-content mb-4">
            ${content || '<p class="text-muted">No content yet...</p>'}
        </div>
        
        <div class="preview-footer border-top pt-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">
                        <i class="fas fa-user me-1"></i>
                        {{ auth()->user()->name }}
                    </small>
                </div>
                <div>
                    <small class="text-muted">
                        <i class="fas fa-eye me-1"></i>0 views
                    </small>
                </div>
            </div>
        </div>
    `;
}

function previewContent() {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    const type = document.querySelector('input[name="type"]:checked')?.value || 'general';
    
    const typeIcons = {
        'general': 'bullhorn',
        'event': 'calendar-alt',
        'campus': 'university',
        'urgent': 'exclamation-triangle'
    };
    
    const typeColors = {
        'general': 'primary',
        'event': 'info',
        'campus': 'success',
        'urgent': 'danger'
    };
    
    const typeLabels = {
        'general': 'General Announcement',
        'event': 'Event Notice',
        'campus': 'Campus Update',
        'urgent': 'Urgent Notice'
    };
    
    const modalContent = document.getElementById('modalPreviewContent');
    modalContent.innerHTML = `
        <div class="ju-card">
            <div class="ju-card-header bg-${typeColors[type]} text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-${typeIcons[type]} fa-lg me-3"></i>
                    <h4 class="mb-0">${title || 'Untitled Announcement'}</h4>
                </div>
            </div>
            <div class="ju-card-body">
                <div class="announcement-content">
                    ${content || '<p class="text-muted">No content provided.</p>'}
                </div>
            </div>
            <div class="ju-card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>
                            <strong>Author:</strong> {{ auth()->user()->name }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            <strong>Published:</strong> Just now
                        </small>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    previewModal.show();
}

function saveAsDraft() {
    document.getElementById('publish_now').checked = false;
    document.getElementById('announcementForm').submit();
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl+B for bold
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        formatText('bold');
    }
    
    // Ctrl+I for italic
    if ((e.ctrlKey || e.metaKey) && e.key === 'i') {
        e.preventDefault();
        formatText('italic');
    }
    
    // Ctrl+U for underline
    if ((e.ctrlKey || e.metaKey) && e.key === 'u') {
        e.preventDefault();
        formatText('underline');
    }
    
    // Ctrl+S to save as draft
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        saveAsDraft();
    }
    
    // Ctrl+Enter to publish
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('publish_now').checked = true;
        document.getElementById('announcementForm').submit();
    }
});

// Form validation
document.getElementById('announcementForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();
    
    if (!title) {
        e.preventDefault();
        showToast('Please enter a title for the announcement.', 'error');
        document.getElementById('title').focus();
        return;
    }
    
    if (!content) {
        e.preventDefault();
        showToast('Please enter content for the announcement.', 'error');
        document.getElementById('content').focus();
        return;
    }
    
    // If specific audience is selected, check if users are selected
    const specificAudience = document.querySelector('input[name="audience"]:checked')?.value === 'specific';
    if (specificAudience) {
        const selectedUsers = document.querySelectorAll('input[name="target_ids[]"]:checked').length;
        if (selectedUsers === 0) {
            e.preventDefault();
            showToast('Please select at least one user for specific audience.', 'error');
            return;
        }
    }
    
    // Check content length
    if (content.length > 5000) {
        e.preventDefault();
        showToast('Content exceeds maximum length of 5000 characters.', 'error');
        return;
    }
});

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `ju-toast ju-toast-${type} animate__animated animate__fadeInRight`;
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} fa-2x"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <div class="fw-bold mb-1">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button type="button" class="btn-close btn-close-white" onclick="this.closest('.ju-toast').remove()"></button>
        </div>
    `;
    
    const container = document.querySelector('.toast-container') || document.body;
    container.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}
</script>
@endpush