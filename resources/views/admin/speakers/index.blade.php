@extends('layouts.app')

@section('title', 'Speakers Management - Jimma University')

@section('page-title', 'Speakers Management')
@section('page-subtitle', 'Manage all event speakers')

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Speakers</li>
@endsection

@section('content')
<div class="ju-card">
    <div class="ju-card-header d-flex justify-content-between align-items-center">
        <h5 class="ju-card-title mb-0">Speakers List</h5>
        <div>
            <a href="{{ route('speakers.create') }}" class="btn btn-ju">
                <i class="fas fa-plus me-2"></i> Add New Speaker
            </a>
        </div>
    </div>
    
    <div class="ju-card-body">
        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search speakers..." 
                           id="searchInput" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="departmentFilter">
                    <option value="">All Departments</option>
                    <option value="Computer Science" {{ request('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                    <option value="Engineering" {{ request('department') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                    <option value="Medicine" {{ request('department') == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                    <option value="Business" {{ request('department') == 'Business' ? 'selected' : '' }}>Business</option>
                    <option value="Arts" {{ request('department') == 'Arts' ? 'selected' : '' }}>Arts</option>
                    <option value="Science" {{ request('department') == 'Science' ? 'selected' : '' }}>Science</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-ju" id="applyFilters">
                    <i class="fas fa-filter me-2"></i> Apply
                </button>
                <a href="{{ route('speakers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-2"></i> Reset
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="ju-card">
                    <div class="ju-card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: rgba(0, 100, 0, 0.1); color: var(--ju-green);">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">{{ $totalCount }}</h3>
                                <p class="text-muted mb-0">Total Speakers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ju-card">
                    <div class="ju-card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: rgba(25, 135, 84, 0.1); color: #198754;">
                                <i class="fas fa-user-check fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">{{ $activeCount }}</h3>
                                <p class="text-muted mb-0">Active Speakers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ju-card">
                    <div class="ju-card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                                <i class="fas fa-star fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">{{ $featuredCount }}</h3>
                                <p class="text-muted mb-0">Featured Speakers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ju-card">
                    <div class="ju-card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px; background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                                <i class="fas fa-calendar-alt fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0">{{ $upcomingTalks }}</h3>
                                <p class="text-muted mb-0">Upcoming Talks</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Speakers Table -->
        <div class="table-responsive">
            <table class="table table-ju table-hover">
                <thead>
                    <tr>
                        <th>Speaker</th>
                        <th>Title & Department</th>
                        <th>Contact</th>
                        <th>Events</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($speakers as $speaker)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($speaker->photo)
                                <img src="{{ asset('storage/' . $speaker->photo) }}" alt="{{ $speaker->name }}" 
                                     class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; background: var(--ju-light-green); color: var(--ju-green);">
                                    <i class="fas fa-user"></i>
                                </div>
                                @endif
                                <div>
                                    <strong>{{ $speaker->name }}</strong>
                                    @if($speaker->is_featured)
                                    <span class="badge bg-warning ms-2">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $speaker->title }}</div>
                            <small class="text-muted">{{ $speaker->department }}</small>
                        </td>
                        <td>
                            <div><i class="fas fa-envelope text-muted me-2"></i> {{ $speaker->email }}</div>
                            @if($speaker->phone)
                            <div><i class="fas fa-phone text-muted me-2"></i> {{ $speaker->phone }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $speaker->events_count }} events</span>
                        </td>
                        <td>
                            <form action="{{ route('speakers.toggle-active', $speaker) }}" method="POST" class="d-inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-sm {{ $speaker->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $speaker->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('speakers.show', $speaker) }}" class="btn btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete" 
                                            onclick="return confirm('Are you sure you want to delete this speaker?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-user-times fa-3x mb-3"></i>
                                <h5>No speakers found</h5>
                                <p>Start by adding your first speaker</p>
                                <a href="{{ route('speakers.create') }}" class="btn btn-ju mt-2">
                                    <i class="fas fa-plus me-2"></i> Add Speaker
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($speakers->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $speakers->firstItem() }} to {{ $speakers->lastItem() }} of {{ $speakers->total() }} entries
            </div>
            <div>
                {{ $speakers->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const departmentFilter = document.getElementById('departmentFilter');
        const applyFilters = document.getElementById('applyFilters');
        
        applyFilters.addEventListener('click', function() {
            const params = new URLSearchParams();
            
            if (searchInput.value) {
                params.set('search', searchInput.value);
            }
            
            if (statusFilter.value) {
                params.set('status', statusFilter.value);
            }
            
            if (departmentFilter.value) {
                params.set('department', departmentFilter.value);
            }
            
            window.location.href = '{{ route("speakers.index") }}?' + params.toString();
        });
        
        // Enter key to search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters.click();
            }
        });
    });
</script>
@endpush