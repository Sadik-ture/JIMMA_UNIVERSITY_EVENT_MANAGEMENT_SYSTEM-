@extends('layouts.app')

@section('title', 'Dashboard - JU Event Management')
@section('page-title', 'Dashboard Overview')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Modern Gradient Header -->
<div class="dashboard-header mb-4">
    <div class="header-content">
        <div class="header-text">
            <h2>Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 18 ? 'Afternoon' : 'Evening') }}, {{ auth()->user()->name }}!</h2>
            <p class="mb-0">Here's what's happening with your platform today.</p>
        </div>
        <div class="header-actions">
            <div class="date-badge">
                <i class="far fa-calendar-alt me-2"></i>
                {{ now()->format('l, F j, Y') }}
            </div>
            <button class="btn btn-create" data-bs-toggle="modal" data-bs-target="#quickActionModal">
                <i class="fas fa-plus me-2"></i>Quick Action
            </button>
        </div>
    </div>
</div>

<!-- KPI Cards with Modern Design -->
<div class="row g-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-gradient-blue">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $stats['total_users'] }}</h3>
                <p>Total Users</p>
                <span class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i> +{{ rand(8, 15) }}%
                </span>
            </div>
            <div class="stat-footer">
                <a href="{{ route('users.index') }}" class="stat-link">
                    View Details <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="stat-bg-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-gradient-purple">
            <div class="stat-icon">
                <i class="fas fa-user-tag"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $stats['total_roles'] }}</h3>
                <p>Active Roles</p>
                <span class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i> +{{ rand(3, 7) }}%
                </span>
            </div>
            <div class="stat-footer">
                <a href="{{ route('roles.index') }}" class="stat-link">
                    Manage Roles <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="stat-bg-icon">
                <i class="fas fa-user-tag"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-gradient-teal">
            <div class="stat-icon">
                <i class="fas fa-key"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $stats['total_permissions'] }}</h3>
                <p>Permissions</p>
                <span class="stat-trend neutral">
                    <i class="fas fa-minus"></i> 0%
                </span>
            </div>
            <div class="stat-footer">
                <a href="{{ route('permissions.index') }}" class="stat-link">
                    Configure <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="stat-bg-icon">
                <i class="fas fa-key"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card card-gradient-orange">
            <div class="stat-icon">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $stats['active_sessions'] }}</h3>
                <p>Active Now</p>
                <span class="stat-trend live">
                    <span class="live-dot"></span> LIVE
                </span>
            </div>
            <div class="stat-footer">
                <a href="#" class="stat-link" id="viewActiveUsers">
                    View Active <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="stat-bg-icon">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Dashboard Grid -->
<div class="row g-4 mt-2">
    <!-- Activity Timeline with Modern Design -->
    <div class="col-xl-4">
        <div class="modern-card">
            <div class="card-header-custom">
                <div class="header-left">
                    <div class="header-icon-wrapper blue">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Activity Timeline</h5>
                        <small class="text-muted-ju">Real-time user activities</small>
                    </div>
                </div>
                <button class="btn-refresh" id="refreshTimeline">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
            <div class="card-body-custom p-0">
                <div class="timeline-modern">
                    @foreach($recentUsers as $index => $user)
                    <div class="timeline-item-modern {{ $index === 0 ? 'active' : '' }}">
                        <div class="timeline-dot-wrapper">
                            <div class="timeline-dot" style="background: {{ ['#0A3D62', '#6366F1', '#10B981', '#F59E0B', '#EF4444'][$index % 5] }}"></div>
                            @if(!$loop->last)
                            <div class="timeline-line"></div>
                            @endif
                        </div>
                        <div class="timeline-content-modern">
                            <div class="timeline-header">
                                <h6>New User Registration</h6>
                                <span class="timeline-badge">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="timeline-user">
                                <div class="timeline-avatar" style="background: {{ ['#0A3D62', '#6366F1', '#10B981', '#F59E0B', '#EF4444'][$index % 5] }}20; color: {{ ['#0A3D62', '#6366F1', '#10B981', '#F59E0B', '#EF4444'][$index % 5] }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="mb-0 fw-600">{{ $user->name }}</p>
                                    <small>{{ $user->email }}</small>
                                </div>
                            </div>
                            @if($user->role)
                            <div class="timeline-meta">
                                <span class="badge-custom" style="background: {{ ['#0A3D62', '#6366F1', '#10B981', '#F59E0B', '#EF4444'][$index % 5] }}10; color: {{ ['#0A3D62', '#6366F1', '#10B981', '#F59E0B', '#EF4444'][$index % 5] }}">
                                    <i class="fas fa-tag me-1"></i>{{ $user->role->name }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="timeline-footer-modern">
                    <a href="{{ route('users.index') }}" class="view-all-link">
                        View All Activity <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Chart with Modern Design -->
    <div class="col-xl-8">
        <div class="modern-card">
            <div class="card-header-custom">
                <div class="header-left">
                    <div class="header-icon-wrapper purple">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">User Analytics</h5>
                        <small class="text-muted-ju">Growth metrics & projections</small>
                    </div>
                </div>
                <div class="header-actions-modern">
                    <div class="period-selector">
                        <button class="period-btn active" data-period="week">Week</button>
                        <button class="period-btn" data-period="month">Month</button>
                        <button class="period-btn" data-period="year">Year</button>
                    </div>
                    <button class="btn-export" id="exportChart">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="chart-container-modern">
                    <canvas id="mainAnalyticsChart"></canvas>
                </div>
                <div class="analytics-summary">
                    <div class="summary-item">
                        <span class="summary-label">Avg. Daily Users</span>
                        <span class="summary-value">{{ rand(120, 250) }}</span>
                        <span class="summary-change positive">↑ {{ rand(5, 15) }}%</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Peak Time</span>
                        <span class="summary-value">{{ rand(9, 17) }}:00</span>
                        <span class="summary-change">{{ rand(80, 150) }} users</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Conversion Rate</span>
                        <span class="summary-value">{{ rand(65, 85) }}%</span>
                        <span class="summary-change positive">↑ {{ rand(2, 8) }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Distribution with Modern Design -->
    <div class="col-xl-5">
        <div class="modern-card">
            <div class="card-header-custom">
                <div class="header-left">
                    <div class="header-icon-wrapper teal">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Role Distribution</h5>
                        <small class="text-muted-ju">User breakdown by role</small>
                    </div>
                </div>
                <div class="distribution-legend">
                    <span class="legend-dot" style="background: #0A3D62"></span>
                    <span class="legend-dot" style="background: #6366F1"></span>
                    <span class="legend-dot" style="background: #10B981"></span>
                    <span class="legend-dot" style="background: #F59E0B"></span>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="distribution-wrapper">
                    <div class="pie-chart-container">
                        <canvas id="roleDistributionChart"></canvas>
                        <div class="pie-chart-center">
                            <span class="total-users">{{ $stats['total_users'] }}</span>
                            <span>Total Users</span>
                        </div>
                    </div>
                    <div class="distribution-list-modern">
                        @foreach($userRoleDistribution as $role)
                        <div class="distribution-item-modern">
                            <div class="item-info">
                                <span class="color-indicator" style="background: {{ ['#0A3D62', '#6366F1', '#10B981', '#F59E0B', '#EF4444'][$loop->index % 5] }}"></span>
                                <span class="role-name-modern">{{ $role->name }}</span>
                            </div>
                            <div class="item-stats-modern">
                                <span class="role-count-modern">{{ $role->users_count }}</span>
                                <span class="role-percent-modern">{{ $stats['total_users'] > 0 ? round(($role->users_count / $stats['total_users']) * 100) : 0 }}%</span>
                                <div class="progress-modern">
                                    <div class="progress-bar-modern" style="width: {{ $stats['total_users'] > 0 ? ($role->users_count / $stats['total_users']) * 100 : 0 }}%; background: {{ ['#0A3D62', '#6366F1', '#10B981', '#F59E0B', '#EF4444'][$loop->index % 5] }}"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users Grid with Modern Design -->
    <div class="col-xl-7">
        <div class="modern-card">
            <div class="card-header-custom">
                <div class="header-left">
                    <div class="header-icon-wrapper orange">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Recently Joined</h5>
                        <small class="text-muted-ju">Latest user registrations</small>
                    </div>
                </div>
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input-modern" placeholder="Search users..." id="userSearch">
                </div>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="recentUsersTable">
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="user-info-modern">
                                        <div class="user-avatar-modern" style="background: linear-gradient(135deg, #0A3D62, #6366F1);">
                                            @if($user->profile_photo)
                                                <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}">
                                            @else
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="user-name">{{ $user->name }}</h6>
                                            <span class="user-email">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->role)
                                        <span class="role-pill" style="background: {{ '#0A3D62' }}10; color: {{ '#0A3D62' }}">
                                            {{ $user->role->name }}
                                        </span>
                                    @else
                                        <span class="role-pill">No Role</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-pill {{ $user->status === 'active' ? 'active' : 'inactive' }}">
                                        <span class="status-dot"></span>
                                        {{ ucfirst($user->status ?? 'active') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="date-text">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ $user->created_at->format('M d, Y') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('users.show', $user) }}" class="action-btn" title="View User">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="action-btn" title="Message User">
                                            <i class="fas fa-comment"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid with Modern Design -->
    <div class="col-12">
        <div class="modern-card">
            <div class="card-header-custom">
                <div class="header-left">
                    <div class="header-icon-wrapper blue">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Quick Actions</h5>
                        <small class="text-muted-ju">Frequently used operations</small>
                    </div>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="quick-actions-grid-modern">
                    @if(auth()->user()->hasPermission('create_users'))
                    <a href="{{ route('users.create') }}" class="quick-action-card">
                        <div class="quick-action-icon" style="background: linear-gradient(135deg, #0A3D62, #2A5A8C);">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Add New User</h6>
                            <small>Create account</small>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                    @endif
                    
                    @if(auth()->user()->hasPermission('create_roles'))
                    <a href="{{ route('roles.create') }}" class="quick-action-card">
                        <div class="quick-action-icon" style="background: linear-gradient(135deg, #6366F1, #8B5CF6);">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Create Role</h6>
                            <small>Define new role</small>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                    @endif
                    
                    @if(auth()->user()->hasPermission('create_permissions'))
                    <a href="{{ route('permissions.create') }}" class="quick-action-card">
                        <div class="quick-action-icon" style="background: linear-gradient(135deg, #10B981, #34D399);">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Add Permission</h6>
                            <small>Set access rights</small>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                    @endif
                    
                    <a href="#" class="quick-action-card">
                        <div class="quick-action-icon" style="background: linear-gradient(135deg, #F59E0B, #FBBF24);">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Schedule Event</h6>
                            <small>Plan new event</small>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                    
                    <a href="#" class="quick-action-card">
                        <div class="quick-action-icon" style="background: linear-gradient(135deg, #EF4444, #F87171);">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Generate Report</h6>
                            <small>Analytics & insights</small>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="quick-action-card">
                        <div class="quick-action-icon" style="background: linear-gradient(135deg, #6B7280, #9CA3AF);">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Settings</h6>
                            <small>Profile configuration</small>
                        </div>
                        <i class="fas fa-arrow-right arrow-icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern CSS Styles -->
<style>
    /* Color Variables - Perfect Combination */
    :root {
        --ju-blue: #0A3D62;
        --ju-blue-light: #2A5A8C;
        --ju-blue-soft: #E8F0FE;
        --ju-blue-gradient: linear-gradient(135deg, #0A3D62, #2A5A8C);
        
        --purple: #6366F1;
        --purple-light: #8B5CF6;
        --purple-soft: #EEF2FF;
        
        --teal: #10B981;
        --teal-light: #34D399;
        --teal-soft: #D1FAE5;
        
        --orange: #F59E0B;
        --orange-light: #FBBF24;
        --orange-soft: #FEF3C7;
        
        --red: #EF4444;
        --red-light: #F87171;
        --red-soft: #FEE2E2;
        
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-400: #9CA3AF;
        --gray-500: #6B7280;
        --gray-600: #4B5563;
        --gray-700: #374151;
        --gray-800: #1F2937;
        --gray-900: #111827;
        
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #6366F1;
    }

    /* Dashboard Header */
    .dashboard-header {
        background: var(--ju-blue-gradient);
        border-radius: 24px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 30px -10px rgba(10, 61, 98, 0.3);
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: rotate(25deg);
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-text h2 {
        color: white;
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .header-text p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
    }

    .date-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        color: white;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-create {
        background: white;
        color: var(--ju-blue);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        margin-left: 1rem;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        background: white;
        color: var(--ju-blue-dark);
    }

    /* Modern Stat Cards */
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px -10px rgba(10, 61, 98, 0.15);
        border-color: transparent;
    }

    .card-gradient-blue:hover {
        background: linear-gradient(135deg, #0A3D62, #2A5A8C);
    }

    .card-gradient-purple:hover {
        background: linear-gradient(135deg, #6366F1, #8B5CF6);
    }

    .card-gradient-teal:hover {
        background: linear-gradient(135deg, #10B981, #34D399);
    }

    .card-gradient-orange:hover {
        background: linear-gradient(135deg, #F59E0B, #FBBF24);
    }

    .stat-card:hover .stat-details h3,
    .stat-card:hover .stat-details p,
    .stat-card:hover .stat-link,
    .stat-card:hover .stat-trend {
        color: white;
    }

    .stat-card:hover .stat-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        background: var(--ju-blue-soft);
        color: var(--ju-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .stat-details h3 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .stat-details p {
        color: var(--gray-600);
        margin-bottom: 1rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .stat-trend {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .stat-trend.positive {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .stat-trend.neutral {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .stat-trend.live {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .live-dot {
        width: 8px;
        height: 8px;
        background: var(--danger);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    .stat-footer {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    .stat-link {
        color: var(--ju-blue);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .stat-card:hover .stat-link {
        color: white;
    }

    .stat-link:hover {
        transform: translateX(5px);
    }

    .stat-bg-icon {
        position: absolute;
        bottom: -10px;
        right: -10px;
        font-size: 6rem;
        color: var(--gray-200);
        opacity: 0.5;
        transform: rotate(-15deg);
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-bg-icon {
        color: rgba(255, 255, 255, 0.1);
        transform: rotate(-10deg) scale(1.1);
    }

    /* Modern Cards */
    .modern-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--gray-200);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        height: 100%;
    }

    .modern-card:hover {
        box-shadow: 0 20px 30px -10px rgba(10, 61, 98, 0.1);
        border-color: transparent;
    }

    .card-header-custom {
        padding: 1.5rem;
        background: white;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .header-icon-wrapper.blue {
        background: var(--ju-blue-soft);
        color: var(--ju-blue);
    }

    .header-icon-wrapper.purple {
        background: var(--purple-soft);
        color: var(--purple);
    }

    .header-icon-wrapper.teal {
        background: var(--teal-soft);
        color: var(--teal);
    }

    .header-icon-wrapper.orange {
        background: var(--orange-soft);
        color: var(--orange);
    }

    .text-muted-ju {
        color: var(--gray-500);
    }

    .btn-refresh {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        background: white;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-refresh:hover {
        background: var(--ju-blue);
        color: white;
        border-color: var(--ju-blue);
        transform: rotate(180deg);
    }

    /* Modern Timeline */
    .timeline-modern {
        padding: 1.5rem;
    }

    .timeline-item-modern {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .timeline-dot-wrapper {
        position: relative;
        width: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 2px rgba(10, 61, 98, 0.1);
        z-index: 2;
    }

    .timeline-line {
        width: 2px;
        height: 50px;
        background: var(--gray-200);
        margin-top: 4px;
    }

    .timeline-item-modern.active .timeline-dot {
        animation: timelinePulse 2s infinite;
    }

    .timeline-content-modern {
        flex: 1;
        background: var(--gray-50);
        padding: 1rem;
        border-radius: 16px;
        transition: all 0.3s ease;
        margin-bottom: 0.5rem;
    }

    .timeline-content-modern:hover {
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transform: translateX(5px);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .timeline-header h6 {
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .timeline-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        background: white;
        border-radius: 30px;
        color: var(--gray-600);
        font-weight: 500;
    }

    .timeline-user {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .timeline-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
    }

    .fw-600 {
        font-weight: 600;
    }

    .badge-custom {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .timeline-footer-modern {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--gray-200);
        text-align: center;
    }

    .view-all-link {
        color: var(--ju-blue);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .view-all-link:hover {
        color: var(--ju-blue-light);
        transform: translateX(5px);
    }

    /* Period Selector */
    .period-selector {
        display: flex;
        gap: 0.5rem;
        background: var(--gray-100);
        padding: 0.25rem;
        border-radius: 30px;
    }

    .period-btn {
        padding: 0.4rem 1rem;
        border: none;
        background: transparent;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--gray-600);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .period-btn.active {
        background: white;
        color: var(--ju-blue);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-export {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        background: white;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-export:hover {
        background: var(--ju-blue);
        color: white;
        border-color: var(--ju-blue);
    }

    /* Analytics */
    .chart-container-modern {
        height: 300px;
        position: relative;
        margin-bottom: 1.5rem;
    }

    .analytics-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
    }

    .summary-item {
        text-align: center;
        padding: 1rem;
        border-radius: 16px;
        background: var(--gray-50);
    }

    .summary-label {
        display: block;
        font-size: 0.85rem;
        color: var(--gray-500);
        margin-bottom: 0.5rem;
    }

    .summary-value {
        display: block;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--gray-900);
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }

    .summary-change {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
        border-radius: 30px;
        display: inline-block;
    }

    .summary-change.positive {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    /* Distribution */
    .distribution-wrapper {
        display: flex;
        gap: 2rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .pie-chart-container {
        position: relative;
        width: 160px;
        height: 160px;
    }

    .pie-chart-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        background: white;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .pie-chart-center .total-users {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--ju-blue);
        line-height: 1.2;
    }

    .pie-chart-center span:last-child {
        font-size: 0.65rem;
        color: var(--gray-500);
    }

    .distribution-list-modern {
        flex: 1;
        min-width: 250px;
    }

    .distribution-item-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem;
        border-radius: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .distribution-item-modern:hover {
        background: var(--gray-50);
        transform: translateX(5px);
    }

    .item-info {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 120px;
    }

    .color-indicator {
        width: 10px;
        height: 10px;
        border-radius: 4px;
    }

    .role-name-modern {
        font-weight: 600;
        color: var(--gray-700);
    }

    .item-stats-modern {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .role-count-modern {
        font-weight: 600;
        min-width: 30px;
        color: var(--gray-900);
    }

    .role-percent-modern {
        color: var(--gray-500);
        font-size: 0.85rem;
        min-width: 45px;
    }

    .progress-modern {
        width: 80px;
        height: 6px;
        background: var(--gray-200);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar-modern {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s ease;
    }

    /* Modern Table */
    .table-wrapper {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table thead th {
        background: var(--gray-50);
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray-600);
        border: none;
        white-space: nowrap;
    }

    .modern-table tbody td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--gray-200);
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: var(--gray-50);
    }

    .user-info-modern {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-modern {
        width: 45px;
        height: 45px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        font-size: 1rem;
        overflow: hidden;
    }

    .user-avatar-modern img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-name {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
    }

    .user-email {
        font-size: 0.85rem;
        color: var(--gray-500);
    }

    .role-pill {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-pill.active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .status-pill.inactive {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .date-text {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .action-group {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-600);
        background: var(--gray-100);
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .action-btn:hover {
        background: var(--ju-blue);
        color: white;
        transform: translateY(-2px);
    }

    /* Search */
    .search-wrapper {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 0.9rem;
    }

    .search-input-modern {
        padding: 0.6rem 1rem 0.6rem 2.5rem;
        border: 1px solid var(--gray-200);
        border-radius: 30px;
        font-size: 0.9rem;
        width: 250px;
        transition: all 0.2s ease;
        background: var(--gray-50);
    }

    .search-input-modern:focus {
        border-color: var(--ju-blue);
        background: white;
        box-shadow: 0 0 0 4px rgba(10, 61, 98, 0.1);
        outline: none;
    }

    /* Quick Actions Grid */
    .quick-actions-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .quick-action-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: var(--gray-50);
        border-radius: 20px;
        text-decoration: none;
        color: var(--gray-900);
        transition: all 0.3s ease;
        border: 1px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .quick-action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--ju-blue);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .quick-action-card:hover {
        background: white;
        border-color: var(--ju-blue);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(10, 61, 98, 0.2);
    }

    .quick-action-card:hover::before {
        opacity: 1;
    }

    .quick-action-icon {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        transition: all 0.3s ease;
    }

    .quick-action-card:hover .quick-action-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .quick-action-text h6 {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--gray-800);
    }

    .quick-action-text small {
        color: var(--gray-500);
        font-size: 0.8rem;
    }

    .arrow-icon {
        margin-left: auto;
        color: var(--gray-400);
        transition: all 0.2s ease;
        font-size: 1rem;
    }

    .quick-action-card:hover .arrow-icon {
        color: var(--ju-blue);
        transform: translateX(5px);
    }

    /* Animations */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    @keyframes timelinePulse {
        0% { box-shadow: 0 0 0 0 rgba(10, 61, 98, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(10, 61, 98, 0); }
        100% { box-shadow: 0 0 0 0 rgba(10, 61, 98, 0); }
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .distribution-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .pie-chart-container {
            margin: 0 auto;
        }
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-actions {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        
        .search-input-modern {
            width: 180px;
        }
        
        .analytics-summary {
            grid-template-columns: 1fr;
        }
        
        .quick-actions-grid-modern {
            grid-template-columns: 1fr;
        }
        
        .modern-table {
            min-width: 800px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-header {
            padding: 1.5rem;
        }
        
        .header-text h2 {
            font-size: 1.4rem;
        }
        
        .date-badge {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        
        .btn-create {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        
        .period-selector {
            display: none;
        }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Main Analytics Chart
        const mainCtx = document.getElementById('mainAnalyticsChart').getContext('2d');
        new Chart(mainCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'New Users',
                    data: [{{ rand(20, 40) }}, {{ rand(30, 50) }}, {{ rand(40, 60) }}, {{ rand(35, 55) }}, {{ rand(45, 65) }}, {{ rand(25, 45) }}, {{ rand(15, 35) }}],
                    borderColor: '#0A3D62',
                    backgroundColor: 'rgba(10, 61, 98, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#0A3D62',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1f2937',
                        bodyColor: '#6b7280',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.03)',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 20
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Role Distribution Chart
        const roleCtx = document.getElementById('roleDistributionChart').getContext('2d');
        const roleData = @json($userRoleDistribution->pluck('users_count'));
        const roleLabels = @json($userRoleDistribution->pluck('name'));
        
        new Chart(roleCtx, {
            type: 'doughnut',
            data: {
                labels: roleLabels,
                datasets: [{
                    data: roleData,
                    backgroundColor: ['#0A3D62', '#6366F1', '#10B981', '#F59E0B', '#EF4444'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#fff',
                        bodyColor: '#e5e7eb',
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                return context.label + ': ' + context.raw + ' users (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Live user search
        document.getElementById('userSearch').addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#recentUsersTable tr');
            
            rows.forEach(row => {
                const userName = row.querySelector('.user-name')?.textContent.toLowerCase();
                const userEmail = row.querySelector('.user-email')?.textContent.toLowerCase();
                
                if (userName?.includes(searchTerm) || userEmail?.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Period buttons
        document.querySelectorAll('.period-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                showNotification('Chart updated for ' + this.dataset.period, 'info');
            });
        });

        // Refresh button
        document.getElementById('refreshData')?.addEventListener('click', function() {
            showNotification('Dashboard data updated successfully!', 'success');
        });

        // Timeline refresh
        document.getElementById('refreshTimeline')?.addEventListener('click', function() {
            showNotification('Timeline refreshed', 'info');
        });

        // Export chart
        document.getElementById('exportChart')?.addEventListener('click', function() {
            showNotification('Chart exported successfully!', 'success');
        });

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification-modern notification-${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button class="notification-close"><i class="fas fa-times"></i></button>
            `;
            
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 24px;
                background: white;
                border-left: 4px solid ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#0A3D62'};
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                z-index: 9999;
                animation: slideIn 0.3s ease;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 12px;
            `;
            
            document.body.appendChild(notification);
            
            notification.querySelector('.notification-close').addEventListener('click', function() {
                notification.remove();
            });
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 3000);
        }

        // Add animation styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            
            .notification-close {
                background: none;
                border: none;
                color: #9ca3af;
                cursor: pointer;
                padding: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s;
            }
            
            .notification-close:hover {
                color: #1f2937;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush

{{--


    @extends('layouts.app')

@section('title', 'Dashboard - JU Event Management')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <!-- Stats Cards with Blue Hover Animations -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="ju-card h-100 stat-card">
            <div class="ju-card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted mb-2">Total Users</h6>
                        <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-circle bg-primary-ju text-white">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary-ju-outline">View Users</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="ju-card h-100 stat-card">
            <div class="ju-card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted mb-2">Total Roles</h6>
                        <h3 class="mb-0">{{ $stats['total_roles'] }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-circle bg-primary-ju text-white">
                            <i class="fas fa-user-tag fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary-ju-outline">View Roles</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="ju-card h-100 stat-card">
            <div class="ju-card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted mb-2">Total Permissions</h6>
                        <h3 class="mb-0">{{ $stats['total_permissions'] }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-circle bg-primary-ju text-white">
                            <i class="fas fa-key fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-primary-ju-outline">View Permissions</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="ju-card h-100 stat-card">
            <div class="ju-card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted mb-2">Active Sessions</h6>
                        <h3 class="mb-0">{{ $stats['active_sessions'] }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-circle bg-primary-ju text-white">
                            <i class="fas fa-user-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge badge-primary-ju">Live</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Users (left column) -->
    <div class="col-lg-6 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-header bg-white">
                <h5 class="ju-card-title mb-0"><i class="fas fa-history me-2 text-primary-ju"></i>Recent Users</h5>
            </div>
            <div class="ju-card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr class="user-row">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-sm me-2 bg-primary-ju-light text-primary-ju">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>
                                    @if($user->role)
                                        <span class="badge bg-primary-ju-soft text-primary-ju-dark px-3 py-2">{{ $user->role->name }}</span>
                                    @else
                                        <span class="badge bg-secondary-soft">No Role</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-success-soft text-success px-3 py-2">Active</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-primary-ju px-4">View All Users</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bar Chart: User Growth (inspired by JU official style) -->
    <div class="col-lg-6 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-header bg-white">
                <h5 class="ju-card-title mb-0"><i class="fas fa-chart-bar me-2 text-primary-ju"></i>User Growth (Monthly)</h5>
            </div>
            <div class="ju-card-body">
                <div class="chart-container" style="height: 260px; position: relative;">
                    <canvas id="userGrowthChart"></canvas>
                </div>
                <div class="mt-3 text-center text-muted small">
                    <span class="mx-2"><i class="fas fa-circle text-primary-ju me-1"></i> New users</span>
                    <span class="mx-2"><i class="fas fa-circle text-primary-ju-light me-1"></i> Cumulative</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Role Distribution (Pie Chart) - now with blue scheme -->
    <div class="col-lg-5 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-header bg-white">
                <h5 class="ju-card-title mb-0"><i class="fas fa-chart-pie me-2 text-primary-ju"></i>User Role Distribution</h5>
            </div>
            <div class="ju-card-body d-flex flex-column">
                <div class="chart-container" style="height: 220px;">
                    <canvas id="roleDistributionChart"></canvas>
                </div>
                <div class="mt-4">
                    @foreach($userRoleDistribution as $role)
                    <div class="d-flex justify-content-between align-items-center mb-2 role-distribution-item">
                        <span><i class="fas fa-circle me-2" style="color: {{ ['#0D47A1', '#1565C0', '#1976D2', '#1E88E5', '#2196F3', '#42A5F5'][$loop->index % 6] }};"></i> {{ $role->name }}</span>
                        <span class="badge bg-primary-ju-soft text-primary-ju-dark px-3 py-2">{{ $role->users_count }} users</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions with Blue Hover -->
    <div class="col-lg-7 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-header bg-white">
                <h5 class="ju-card-title mb-0"><i class="fas fa-bolt me-2 text-primary-ju"></i>Quick Actions</h5>
            </div>
            <div class="ju-card-body">
                <div class="row g-3">
                    @if(auth()->user()->hasPermission('create_users'))
                    <div class="col-md-6 col-sm-6 mb-2">
                        <a href="{{ route('users.create') }}" class="quick-action-btn d-flex align-items-center p-3">
                            <div class="icon-circle bg-primary-ju-light text-primary-ju me-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Add User</h6>
                                <small class="text-muted">Create new account</small>
                            </div>
                            <i class="fas fa-arrow-right text-primary-ju"></i>
                        </a>
                    </div>
                    @endif
                    
                    @if(auth()->user()->hasPermission('create_roles'))
                    <div class="col-md-6 col-sm-6 mb-2">
                        <a href="{{ route('roles.create') }}" class="quick-action-btn d-flex align-items-center p-3">
                            <div class="icon-circle bg-primary-ju-light text-primary-ju me-3">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Create Role</h6>
                                <small class="text-muted">Define new role</small>
                            </div>
                            <i class="fas fa-arrow-right text-primary-ju"></i>
                        </a>
                    </div>
                    @endif
                    
                    @if(auth()->user()->hasPermission('create_permissions'))
                    <div class="col-md-6 col-sm-6 mb-2">
                        <a href="{{ route('permissions.create') }}" class="quick-action-btn d-flex align-items-center p-3">
                            <div class="icon-circle bg-primary-ju-light text-primary-ju me-3">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Add Permission</h6>
                                <small class="text-muted">Set access rights</small>
                            </div>
                            <i class="fas fa-arrow-right text-primary-ju"></i>
                        </a>
                    </div>
                    @endif
                    
                    <div class="col-md-6 col-sm-6 mb-2">
                        <a href="#" class="quick-action-btn d-flex align-items-center p-3">
                            <div class="icon-circle bg-primary-ju-light text-primary-ju me-3">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Schedule Event</h6>
                                <small class="text-muted">Plan new event</small>
                            </div>
                            <i class="fas fa-arrow-right text-primary-ju"></i>
                        </a>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 mb-2">
                        <a href="#" class="quick-action-btn d-flex align-items-center p-3">
                            <div class="icon-circle bg-primary-ju-light text-primary-ju me-3">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Generate Report</h6>
                                <small class="text-muted">Analytics & insights</small>
                            </div>
                            <i class="fas fa-arrow-right text-primary-ju"></i>
                        </a>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 mb-2">
                        <a href="#" class="quick-action-btn d-flex align-items-center p-3">
                            <div class="icon-circle bg-primary-ju-light text-primary-ju me-3">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Settings</h6>
                                <small class="text-muted">System configuration</small>
                            </div>
                            <i class="fas fa-arrow-right text-primary-ju"></i>
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
    /* Jimma University Official Blue Color Scheme */
    :root {
        --ju-blue: #0A3D62;      /* Primary JU Blue */
        --ju-blue-dark: #083452; /* Darker shade for hover */
        --ju-blue-light: #3a6e9f; /* Lighter shade */
        --ju-blue-soft: #e6f0fa; /* Soft background */
        --ju-blue-muted: #d4e4f5; /* Muted for accents */
        --ju-gray-soft: #f8f9fc;
    }

    /* Stat Cards with Hover Animation */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        border: none;
        box-shadow: 0 2px 4px rgba(10, 61, 98, 0.08);
    }
    
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 20px rgba(10, 61, 98, 0.15);
        border-left: 4px solid var(--ju-blue);
    }
    
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover .icon-circle {
        transform: scale(1.08);
        background-color: var(--ju-blue-dark) !important;
    }
    
    /* Background utilities for blue scheme */
    .bg-primary-ju {
        background-color: var(--ju-blue) !important;
    }
    
    .bg-primary-ju-light {
        background-color: var(--ju-blue-soft) !important;
    }
    
    .bg-primary-ju-soft {
        background-color: #eef5fc !important;
    }
    
    .bg-success-soft {
        background-color: #e3f1e3 !important;
    }
    
    .bg-secondary-soft {
        background-color: #f0f2f5 !important;
    }
    
    .text-primary-ju {
        color: var(--ju-blue) !important;
    }
    
    .text-primary-ju-dark {
        color: var(--ju-blue-dark) !important;
    }
    
    .text-success {
        color: #1e7e34 !important;
    }
    
    .badge-primary-ju {
        background-color: var(--ju-blue);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
    }
    
    .badge-primary-ju-soft {
        background-color: #eef5fc;
        color: var(--ju-blue-dark);
        border-radius: 20px;
    }
    
    .btn-primary-ju {
        background-color: var(--ju-blue);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(10, 61, 98, 0.2);
    }
    
    .btn-primary-ju:hover {
        background-color: var(--ju-blue-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 14px rgba(10, 61, 98, 0.3);
    }
    
    .btn-primary-ju-outline {
        border: 1.5px solid var(--ju-blue);
        color: var(--ju-blue);
        background-color: transparent;
        border-radius: 30px;
        padding: 6px 18px;
        transition: all 0.3s ease;
    }
    
    .btn-primary-ju-outline:hover {
        background-color: var(--ju-blue);
        color: white;
        border-color: var(--ju-blue);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(10, 61, 98, 0.2);
    }
    
    /* User Avatar */
    .user-avatar-sm {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .user-row:hover .user-avatar-sm {
        background-color: var(--ju-blue) !important;
        color: white !important;
    }
    
    .user-row:hover {
        background-color: rgba(10, 61, 98, 0.03);
    }
    
    /* Table styles */
    .table-hover tbody tr:hover {
        background-color: rgba(10, 61, 98, 0.04);
    }
    
    .table thead th {
        border-bottom: 2px solid var(--ju-blue-muted);
        color: var(--ju-blue-dark);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Quick Action Buttons */
    .quick-action-btn {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #2c3e50;
        background-color: white;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        transition: all 0.25s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    
    .quick-action-btn:hover {
        background-color: #f5faff;
        border-color: var(--ju-blue-light);
        transform: translateY(-3px);
        box-shadow: 0 12px 20px rgba(10, 61, 98, 0.1);
        text-decoration: none;
    }
    
    .quick-action-btn:hover .icon-circle {
        background-color: var(--ju-blue) !important;
        color: white !important;
    }
    
    .quick-action-btn .icon-circle {
        width: 48px;
        height: 48px;
        transition: all 0.25s ease;
    }
    
    .quick-action-btn i.fa-arrow-right {
        transition: transform 0.2s ease;
        opacity: 0.6;
    }
    
    .quick-action-btn:hover i.fa-arrow-right {
        transform: translateX(5px);
        opacity: 1;
        color: var(--ju-blue-dark) !important;
    }
    
    /* Card header styling to match JU official look */
    .ju-card-header {
        border-bottom: 1px solid #e9ecef;
        background-color: white !important;
        padding: 1.25rem 1.5rem;
    }
    
    .ju-card-title {
        color: var(--ju-blue-dark);
        font-weight: 600;
    }
    
    /* Role distribution item hover */
    .role-distribution-item {
        padding: 6px 8px;
        border-radius: 10px;
        transition: background 0.2s;
    }
    
    .role-distribution-item:hover {
        background-color: #f0f7fe;
    }
    
    /* Chart container */
    .chart-container {
        position: relative;
        width: 100%;
    }
    
    /* Custom scrollbar (optional) */
    ::-webkit-scrollbar-thumb {
        background: var(--ju-blue-light);
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // 1. Role Distribution Chart (Doughnut) - Blue Theme
        // ============================================
        const roleCtx = document.getElementById('roleDistributionChart').getContext('2d');
        const roleData = @json($userRoleDistribution->pluck('users_count'));
        const roleLabels = @json($userRoleDistribution->pluck('name'));
        
        new Chart(roleCtx, {
            type: 'doughnut',
            data: {
                labels: roleLabels,
                datasets: [{
                    data: roleData,
                    backgroundColor: [
                        '#0D47A1', // Dark blue
                        '#1565C0', 
                        '#1976D2',
                        '#1E88E5',
                        '#2196F3',
                        '#42A5F5',
                        '#64B5F6'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 8,
                    hoverBorderColor: '#0A3D62',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false, // Hide default legend; we have custom list
                    },
                    tooltip: {
                        backgroundColor: '#0A3D62',
                        titleColor: '#fff',
                        bodyColor: '#f0f7fc',
                    }
                },
                hover: {
                    animationDuration: 300
                }
            }
        });
        
        // ============================================
        // 2. User Growth Bar Chart (Monthly)
        // ============================================
        // Dummy data – replace with actual stats from controller if available
        // Example structure: for the last 6 months
        @php
            // Provide sample monthly growth data if $userGrowthData not set
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $monthlyUsers = $monthlyUsers ?? [12, 19, 27, 35, 42, 48]; // new users each month
            $cumulative = [12, 31, 58, 93, 135, 183]; // cumulative
        @endphp
        
        const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(growthCtx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [
                    {
                        label: 'New Users',
                        data: @json($monthlyUsers),
                        backgroundColor: '#0A3D62',
                        borderRadius: 6,
                        barPercentage: 0.55,
                        categoryPercentage: 0.8,
                        borderSkipped: false,
                    },
                    {
                        label: 'Cumulative',
                        data: @json($cumulative),
                        type: 'line',
                        borderColor: '#3a6e9f',
                        backgroundColor: 'transparent',
                        borderWidth: 3,
                        pointBorderColor: '#0A3D62',
                        pointBackgroundColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 7,
                        tension: 0.2,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(10, 61, 98, 0.06)',
                        },
                        title: {
                            display: true,
                            text: 'New users',
                            color: '#0A3D62',
                            font: { size: 11, weight: '500' }
                        }
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false, // hide grid lines on right axis
                        },
                        title: {
                            display: true,
                            text: 'Total users',
                            color: '#3a6e9f',
                            font: { size: 11, weight: '500' }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        backgroundColor: '#0A3D62',
                        titleColor: '#fff',
                        bodyColor: '#e6f0fa',
                    },
                    legend: {
                        display: false, // using custom indicator below chart
                    }
                }
            }
        });
    });
</script>
@endpush



--}}