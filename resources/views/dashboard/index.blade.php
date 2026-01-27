@extends('layouts.app')

@section('title', 'Dashboard - JU Event Management')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted mb-2">Total Users</h6>
                        <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-circle bg-ju text-white">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-ju-outline">View Users</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted mb-2">Total Roles</h6>
                        <h3 class="mb-0">{{ $stats['total_roles'] }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-circle bg-ju text-white">
                            <i class="fas fa-user-tag fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-ju-outline">View Roles</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted mb-2">Total Permissions</h6>
                        <h3 class="mb-0">{{ $stats['total_permissions'] }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-circle bg-ju text-white">
                            <i class="fas fa-key fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-ju-outline">View Permissions</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="text-muted mb-2">Active Sessions</h6>
                        <h3 class="mb-0">{{ $stats['active_sessions'] }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon-circle bg-ju text-white">
                            <i class="fas fa-user-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge badge-ju">Live</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Users -->
    <div class="col-lg-8 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0"><i class="fas fa-history me-2"></i>Recent Users</h5>
            </div>
            <div class="ju-card-body">
                <div class="table-responsive">
                    <table class="table table-ju">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar-sm me-2">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role)
                                        <span class="badge badge-ju">{{ $user->role->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">No Role</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-ju">View All Users</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Distribution -->
    <div class="col-lg-4 mb-4">
        <div class="ju-card h-100">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0"><i class="fas fa-chart-pie me-2"></i>User Role Distribution</h5>
            </div>
            <div class="ju-card-body">
                <div class="chart-container" style="height: 250px;">
                    <canvas id="roleDistributionChart"></canvas>
                </div>
                <div class="mt-4">
                    @foreach($userRoleDistribution as $role)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $role->name }}</span>
                        <span class="badge bg-ju">{{ $role->users_count }} users</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-12">
        <div class="ju-card">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="ju-card-body">
                <div class="row">
                    @if(auth()->user()->hasPermission('create_users'))
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-ju w-100 h-100 py-4">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            Add User
                        </a>
                    </div>
                    @endif
                    
                    @if(auth()->user()->hasPermission('create_roles'))
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('roles.create') }}" class="btn btn-ju w-100 h-100 py-4">
                            <i class="fas fa-user-tag fa-2x mb-2"></i><br>
                            Create Role
                        </a>
                    </div>
                    @endif
                    
                    @if(auth()->user()->hasPermission('create_permissions'))
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('permissions.create') }}" class="btn btn-ju w-100 h-100 py-4">
                            <i class="fas fa-key fa-2x mb-2"></i><br>
                            Add Permission
                        </a>
                    </div>
                    @endif
                    
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="#" class="btn btn-ju-outline w-100 h-100 py-4">
                            <i class="fas fa-calendar-plus fa-2x mb-2"></i><br>
                            Schedule Event
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
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .user-avatar-sm {
        width: 30px;
        height: 30px;
        background: var(--ju-light-green);
        color: var(--ju-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Role Distribution Chart
        const ctx = document.getElementById('roleDistributionChart').getContext('2d');
        const roleData = @json($userRoleDistribution->pluck('users_count'));
        const roleLabels = @json($userRoleDistribution->pluck('name'));
        
        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: roleLabels,
                datasets: [{
                    data: roleData,
                    backgroundColor: [
                        '#006400', // JU Green
                        '#228B22', // Forest Green
                        '#32CD32', // Lime Green
                        '#90EE90', // Light Green
                        '#98FB98', // Pale Green
                        '#C1E1C1'  // Very Light Green
                    ],
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush