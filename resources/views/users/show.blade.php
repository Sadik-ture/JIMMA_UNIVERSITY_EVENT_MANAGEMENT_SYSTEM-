@extends('layouts.app')

@section('title', 'User Details - JU Event Management')
@section('page-title', 'User Details')
@section('page-subtitle', 'View user information and permissions')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- User Profile Card -->
        <div class="ju-card mb-4">
            <div class="ju-card-body text-center">
                <div class="user-profile-avatar mb-3">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                
                <div class="mb-4">
                    @if($user->role)
                        <span class="badge badge-ju fs-6 px-3 py-2">{{ $user->role->name }}</span>
                    @else
                        <span class="badge bg-secondary fs-6 px-3 py-2">No Role Assigned</span>
                    @endif
                </div>
                
                <div class="d-grid gap-2">
                    @if(auth()->user()->hasPermission('edit_users'))
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-ju">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </a>
                    @endif
                    
                    <button type="button" class="btn btn-ju-outline" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
                        <i class="fas fa-envelope me-2"></i>Send Message
                    </button>
                </div>
            </div>
        </div>
        
        <!-- User Stats -->
        <div class="ju-card">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0"><i class="fas fa-chart-bar me-2"></i>User Statistics</h5>
            </div>
            <div class="ju-card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-calendar-alt me-2"></i>Joined</span>
                        <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-clock me-2"></i>Last Updated</span>
                        <strong>{{ $user->updated_at->format('M d, Y') }}</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-user-check me-2"></i>Status</span>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-key me-2"></i>Password Age</span>
                        <strong>30 days</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- User Details Tabs -->
        <div class="ju-card">
            <div class="ju-card-header">
                <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" 
                                data-bs-target="#details" type="button" role="tab">
                            <i class="fas fa-info-circle me-2"></i>Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" 
                                data-bs-target="#permissions" type="button" role="tab">
                            <i class="fas fa-key me-2"></i>Permissions
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="activity-tab" data-bs-toggle="tab" 
                                data-bs-target="#activity" type="button" role="tab">
                            <i class="fas fa-history me-2"></i>Activity
                        </button>
                    </li>
                </ul>
            </div>
            
            <div class="ju-card-body">
                <div class="tab-content" id="userTabsContent">
                    <!-- Details Tab -->
                    <div class="tab-pane fade show active" id="details" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Basic Information</h6>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Full Name</label>
                                    <p class="fs-5">{{ $user->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Email Address</label>
                                    <p class="fs-5">{{ $user->email }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">User ID</label>
                                    <p class="fs-5">#{{ $user->id }}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h6 class="mb-3">Role Information</h6>
                                @if($user->role)
                                <div class="mb-3">
                                    <label class="form-label text-muted">Assigned Role</label>
                                    <p class="fs-5">
                                        <span class="badge badge-ju">{{ $user->role->name }}</span>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Role Description</label>
                                    <p>{{ $user->role->description ?: 'No description available.' }}</p>
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    This user has no role assigned. Please assign a role to grant permissions.
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h6 class="mb-3">Account Settings</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                        <label class="form-check-label" for="emailNotifications">
                                            Email Notifications
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                        <label class="form-check-label" for="twoFactorAuth">
                                            Two-Factor Authentication
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="accountLocked">
                                        <label class="form-check-label" for="accountLocked">
                                            Account Locked
                                        </label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="forcePasswordReset">
                                        <label class="form-check-label" for="forcePasswordReset">
                                            Force Password Reset
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permissions Tab -->
                    <div class="tab-pane fade" id="permissions" role="tabpanel">
                        @if($user->role && $user->role->permissions->count() > 0)
                        <h6 class="mb-3">Role-Based Permissions</h6>
                        <p class="text-muted mb-4">Permissions inherited from the <strong>{{ $user->role->name }}</strong> role:</p>
                        
                        <div class="row">
                            @foreach($user->role->permissions as $permission)
                            <div class="col-md-6 mb-3">
                                <div class="card border-success border-start border-3">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            {{ $permission->name }}
                                        </h6>
                                        <p class="card-text text-muted small mb-0">
                                            {{ $permission->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="alert alert-info alert-ju mt-4">
                            <i class="fas fa-info-circle me-2"></i>
                            To modify these permissions, edit the <a href="{{ route('roles.edit', $user->role) }}" class="alert-link">{{ $user->role->name }}</a> role.
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-key fa-3x text-muted mb-3"></i>
                            <h5>No Permissions Assigned</h5>
                            <p class="text-muted">This user has no permissions. Assign a role to grant permissions.</p>
                            @if(auth()->user()->hasPermission('edit_users'))
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-ju">
                                <i class="fas fa-user-tag me-2"></i>Assign Role
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    <!-- Activity Tab -->
                    <div class="tab-pane fade" id="activity" role="tabpanel">
                        <h6 class="mb-3">Recent Activity</h6>
                        
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Account Created</h6>
                                    <p class="text-muted mb-0">{{ $user->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Last Profile Update</h6>
                                    <p class="text-muted mb-0">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Last Login</h6>
                                    <p class="text-muted mb-0">Today, 10:30 AM</p>
                                </div>
                            </div>
                            
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Password Changed</h6>
                                    <p class="text-muted mb-0">2 weeks ago</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button class="btn btn-ju-outline">
                                <i class="fas fa-history me-2"></i>View Full Activity Log
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="ju-card text-center h-100">
                    <div class="ju-card-body">
                        <i class="fas fa-redo-alt fa-2x text-primary mb-3"></i>
                        <h6>Reset Password</h6>
                        <p class="small text-muted">Send password reset email</p>
                        <button class="btn btn-sm btn-ju-outline">Reset</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="ju-card text-center h-100">
                    <div class="ju-card-body">
                        <i class="fas fa-user-lock fa-2x text-warning mb-3"></i>
                        <h6>Lock Account</h6>
                        <p class="small text-muted">Temporarily disable access</p>
                        <button class="btn btn-sm btn-ju-outline">Lock</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="ju-card text-center h-100">
                    <div class="ju-card-body">
                        <i class="fas fa-file-export fa-2x text-success mb-3"></i>
                        <h6>Export Data</h6>
                        <p class="small text-muted">Download user information</p>
                        <button class="btn btn-sm btn-ju-outline">Export</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Send Message Modal -->
<div class="modal fade" id="sendMessageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Message to {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" placeholder="Enter message subject">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="4" placeholder="Type your message here..."></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="sendCopy">
                        <label class="form-check-label" for="sendCopy">
                            Send a copy to my email
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ju-outline" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-ju">Send Message</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .user-profile-avatar {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--ju-green) 0%, var(--ju-dark-green) 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 2.5rem;
        margin: 0 auto;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }
    
    .timeline-content {
        padding-left: 10px;
    }
    
    .nav-tabs .nav-link {
        color: #666;
        border: none;
        padding: 10px 20px;
    }
    
    .nav-tabs .nav-link.active {
        color: var(--ju-green);
        border-bottom: 2px solid var(--ju-green);
        background: transparent;
    }
</style>
@endpush