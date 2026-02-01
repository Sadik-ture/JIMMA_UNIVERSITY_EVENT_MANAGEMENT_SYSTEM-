@extends('layouts.app')

@section('title', 'Announcement Statistics - Jimma University')
@section('page-title', 'Announcement Statistics')
@section('page-subtitle', 'Analytics & Insights for University Announcements')

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{ route('announcements.index') }}">Announcements</a></li>
<li class="breadcrumb-item active">Statistics</li>
@endsection

@section('content')
<style>
    .stat-card-lg {
        padding: 2rem;
        min-height: 180px;
    }
    
    .stat-number-lg {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .stat-label-lg {
        font-size: 1.2rem;
        opacity: 0.9;
    }
    
    .chart-container {
        background: white;
        border-radius: var(--ju-radius-lg);
        padding: 1.5rem;
        box-shadow: var(--ju-shadow-md);
        height: 100%;
    }
    
    .trend-up {
        color: var(--ju-success);
    }
    
    .trend-down {
        color: var(--ju-danger);
    }
    
    .percentage-badge {
        font-size: 0.85rem;
        padding: 0.25rem 0.75rem;
        border-radius: var(--ju-radius-full);
    }
    
    .table-stats td {
        vertical-align: middle;
        padding: 1rem;
    }
    
    .progress-thin {
        height: 8px;
        border-radius: var(--ju-radius-full);
    }
</style>

<div class="container-fluid">
    <!-- Main Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-card-lg">
                <div class="stat-number-lg">{{ number_format($totalAnnouncements) }}</div>
                <div class="stat-label-lg">Total Announcements</div>
                <div class="d-flex align-items-center mt-2">
                    <i class="fas fa-bullhorn me-2"></i>
                    <small>All time</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-success stat-card-lg">
                <div class="stat-number-lg">{{ number_format($publishedAnnouncements) }}</div>
                <div class="stat-label-lg">Published</div>
                <div class="d-flex align-items-center mt-2">
                    @php
                        $publishRate = $totalAnnouncements > 0 ? ($publishedAnnouncements / $totalAnnouncements) * 100 : 0;
                    @endphp
                    <span class="percentage-badge bg-white text-dark me-2">{{ round($publishRate, 1) }}%</span>
                    <small>Publish Rate</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-info stat-card-lg">
                <div class="stat-number-lg">{{ number_format($activeAnnouncements) }}</div>
                <div class="stat-label-lg">Active</div>
                <div class="d-flex align-items-center mt-2">
                    @php
                        $activeRate = $publishedAnnouncements > 0 ? ($activeAnnouncements / $publishedAnnouncements) * 100 : 0;
                    @endphp
                    <span class="percentage-badge bg-white text-dark me-2">{{ round($activeRate, 1) }}%</span>
                    <small>Active Rate</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-warning stat-card-lg">
                <div class="stat-number-lg">{{ number_format($totalViews) }}</div>
                <div class="stat-label-lg">Total Views</div>
                <div class="d-flex align-items-center mt-2">
                    @php
                        $avgViews = $totalAnnouncements > 0 ? $totalViews / $totalAnnouncements : 0;
                    @endphp
                    <i class="fas fa-eye me-2"></i>
                    <small>{{ round($avgViews, 1) }} avg views</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Detailed Stats -->
    <div class="row mb-4">
        <!-- By Type Chart -->
        <div class="col-lg-6 mb-4">
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-chart-pie me-2"></i>Announcements by Type
                    </h5>
                </div>
                <div class="ju-card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stats">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                    <th>Total Views</th>
                                    <th>Avg Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($byType as $type)
                                @php
                                    $percentage = $totalAnnouncements > 0 ? ($type->count / $totalAnnouncements) * 100 : 0;
                                    $avgViews = $type->count > 0 ? $type->total_views / $type->count : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <span class="badge bg-{{ $type->type == 'urgent' ? 'danger' : ($type->type == 'event' ? 'primary' : ($type->type == 'campus' ? 'success' : 'info')) }}">
                                            {{ ucfirst($type->type) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">{{ $type->count }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-thin w-100 me-2">
                                                <div class="progress-bar bg-{{ $type->type == 'urgent' ? 'danger' : ($type->type == 'event' ? 'primary' : ($type->type == 'campus' ? 'success' : 'info')) }}" 
                                                     style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span>{{ round($percentage, 1) }}%</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($type->total_views) }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ round($avgViews, 1) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- By Audience Chart -->
        <div class="col-lg-6 mb-4">
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-users me-2"></i>Announcements by Audience
                    </h5>
                </div>
                <div class="ju-card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-stats">
                            <thead>
                                <tr>
                                    <th>Audience</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($byAudience as $audience)
                                @php
                                    $percentage = $totalAnnouncements > 0 ? ($audience->count / $totalAnnouncements) * 100 : 0;
                                    $audienceLabels = [
                                        'all' => 'Everyone',
                                        'students' => 'Students Only',
                                        'faculty' => 'Faculty Only',
                                        'staff' => 'Staff Only',
                                        'specific' => 'Specific Users'
                                    ];
                                @endphp
                                <tr>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $audienceLabels[$audience->audience] ?? ucfirst($audience->audience) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">{{ $audience->count }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress progress-thin w-100 me-2">
                                                <div class="progress-bar bg-info" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span>{{ round($percentage, 1) }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($audience->audience)
                                            @case('all')
                                                Available to all university members
                                                @break
                                            @case('students')
                                                Targeted to students only
                                                @break
                                            @case('faculty')
                                                Targeted to faculty members
                                                @break
                                            @case('staff')
                                                Targeted to staff members
                                                @break
                                            @default
                                                Targeted to specific individuals
                                        @endswitch
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Most Viewed & Recent Announcements -->
    <div class="row">
        <!-- Most Viewed -->
        <div class="col-lg-6 mb-4">
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-fire me-2"></i>Top 10 Most Viewed Announcements
                    </h5>
                </div>
                <div class="ju-card-body">
                    <div class="list-group">
                        @forelse($mostViewed as $index => $announcement)
                        <a href="{{ route('announcements.show', $announcement) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary me-3">{{ $index + 1 }}</span>
                                <div>
                                    <div class="fw-semibold">{{ Str::limit($announcement->title, 50) }}</div>
                                    <small class="text-muted">
                                        {{ $announcement->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-warning me-2">
                                    <i class="fas fa-eye me-1"></i>{{ $announcement->views }}
                                </span>
                                <span class="badge bg-{{ $announcement->type == 'urgent' ? 'danger' : 'info' }}">
                                    {{ ucfirst($announcement->type) }}
                                </span>
                            </div>
                        </a>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No viewed announcements yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="col-lg-6 mb-4">
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-history me-2"></i>Recent Announcements
                    </h5>
                </div>
                <div class="ju-card-body">
                    <div class="list-group">
                        @forelse($recentAnnouncements as $announcement)
                        <a href="{{ route('announcements.show', $announcement) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ Str::limit($announcement->title, 60) }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>{{ $announcement->creator->name ?? 'System' }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="mb-1">
                                        <span class="badge bg-{{ $announcement->type == 'urgent' ? 'danger' : 'primary' }}">
                                            {{ ucfirst($announcement->type) }}
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        {{ $announcement->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent announcements</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends -->
    <div class="row">
        <div class="col-12">
            <div class="ju-card">
                <div class="ju-card-header">
                    <h5 class="ju-card-title">
                        <i class="fas fa-chart-line me-2"></i>Monthly Trends (Last 6 Months)
                    </h5>
                </div>
                <div class="ju-card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Announcements</th>
                                    <th>Total Views</th>
                                    <th>Avg Views per Announcement</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $previousCount = null;
                                    $previousViews = null;
                                @endphp
                                @foreach($monthlyTrend as $month)
                                @php
                                    $avgViews = $month->count > 0 ? $month->total_views / $month->count : 0;
                                    $countTrend = $previousCount !== null ? 
                                        ($previousCount > 0 ? (($month->count - $previousCount) / $previousCount) * 100 : 0) : 0;
                                    $viewsTrend = $previousViews !== null ? 
                                        ($previousViews > 0 ? (($month->total_views - $previousViews) / $previousViews) * 100 : 0) : 0;
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ date('F Y', strtotime($month->month . '-01')) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-2">{{ $month->count }}</span>
                                            @if($countTrend != 0)
                                            <span class="badge {{ $countTrend > 0 ? 'bg-success' : 'bg-danger' }}">
                                                <i class="fas fa-arrow-{{ $countTrend > 0 ? 'up' : 'down' }} me-1"></i>
                                                {{ abs(round($countTrend, 1)) }}%
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bold me-2">{{ number_format($month->total_views) }}</span>
                                            @if($viewsTrend != 0)
                                            <span class="badge {{ $viewsTrend > 0 ? 'bg-success' : 'bg-danger' }}">
                                                <i class="fas fa-arrow-{{ $viewsTrend > 0 ? 'up' : 'down' }} me-1"></i>
                                                {{ abs(round($viewsTrend, 1)) }}%
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ round($avgViews, 1) }}</span>
                                    </td>
                                    <td>
                                        @if($countTrend > 10)
                                        <span class="text-success">
                                            <i class="fas fa-rocket me-1"></i>High Growth
                                        </span>
                                        @elseif($countTrend > 0)
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up me-1"></i>Growing
                                        </span>
                                        @elseif($countTrend < -10)
                                        <span class="text-danger">
                                            <i class="fas fa-arrow-down me-1"></i>Declining
                                        </span>
                                        @elseif($countTrend < 0)
                                        <span class="text-warning">
                                            <i class="fas fa-minus me-1"></i>Stable
                                        </span>
                                        @else
                                        <span class="text-muted">
                                            <i class="fas fa-minus me-1"></i>Steady
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $previousCount = $month->count;
                                    $previousViews = $month->total_views;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Announcements
                    </a>
                    <a href="{{ route('announcements.create') }}" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-plus-circle me-2"></i>Create New Announcement
                    </a>
                </div>
                <div>
                    <button class="btn btn-outline-success" onclick="printStatistics()">
                        <i class="fas fa-print me-2"></i>Print Report
                    </button>
                    <button class="btn btn-outline-info ms-2" onclick="exportStatistics()">
                        <i class="fas fa-download me-2"></i>Export Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function printStatistics() {
    window.print();
}

function exportStatistics() {
    // Simple CSV export
    const data = [
        ['Jimma University - Announcement Statistics Report'],
        ['Generated on: ' + new Date().toLocaleString()],
        [],
        ['Metric', 'Value'],
        ['Total Announcements', '{{ $totalAnnouncements }}'],
        ['Published Announcements', '{{ $publishedAnnouncements }}'],
        ['Active Announcements', '{{ $activeAnnouncements }}'],
        ['Total Views', '{{ $totalViews }}'],
        [],
        ['Announcements by Type'],
        ['Type', 'Count', 'Percentage', 'Total Views', 'Average Views']
    ];
    
    @foreach($byType as $type)
        @php
            $percentage = $totalAnnouncements > 0 ? ($type->count / $totalAnnouncements) * 100 : 0;
            $avgViews = $type->count > 0 ? $type->total_views / $type->count : 0;
        @endphp
        data.push(['{{ ucfirst($type->type) }}', '{{ $type->count }}', '{{ round($percentage, 1) }}%', '{{ $type->total_views }}', '{{ round($avgViews, 1) }}']);
    @endforeach
    
    data.push([], ['Announcements by Audience'], ['Audience', 'Count', 'Percentage']);
    
    @foreach($byAudience as $audience)
        @php
            $percentage = $totalAnnouncements > 0 ? ($audience->count / $totalAnnouncements) * 100 : 0;
        @endphp
        data.push(['{{ $audience->audience }}', '{{ $audience->count }}', '{{ round($percentage, 1) }}%']);
    @endforeach
    
    // Convert to CSV
    const csvContent = data.map(row => 
        row.map(cell => `"${cell}"`).join(',')
    ).join('\n');
    
    // Create download link
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `announcement-statistics-${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showToast('Statistics exported successfully!', 'success');
}

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

<style media="print">
    @media print {
        .ju-header, .ju-sidebar, .ju-footer, .btn, .dropdown,
        .action-buttons, .share-buttons, .toast-container {
            display: none !important;
        }
        
        .ju-main-content {
            padding: 0 !important;
            background: white !important;
            box-shadow: none !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        .ju-card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            margin-bottom: 20px !important;
            break-inside: avoid;
        }
        
        .stat-card-lg {
            border: 1px solid #ddd !important;
            margin-bottom: 20px !important;
        }
        
        .list-group-item {
            border: 1px solid #ddd !important;
            margin-bottom: 5px !important;
        }
        
        .table th {
            background-color: #f8f9fa !important;
            color: #000 !important;
            border: 1px solid #ddd !important;
        }
        
        .table td {
            border: 1px solid #ddd !important;
        }
        
        .badge {
            border: 1px solid #000 !important;
            background-color: #f8f9fa !important;
            color: #000 !important;
        }
        
        .progress-bar {
            background-color: #6c757d !important;
        }
        
        @page {
            margin: 2cm;
        }
        
        body {
            font-size: 12pt !important;
            line-height: 1.4 !important;
        }
        
        h1, h2, h3, h4, h5, h6 {
            page-break-after: avoid;
        }
        
        table {
            page-break-inside: avoid;
        }
    }
</style>
@endpush