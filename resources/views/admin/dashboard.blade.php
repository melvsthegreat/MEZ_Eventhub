@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-lg">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1 fw-bold">Admin Dashboard</h2>
                            <p class="mb-0">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your events.</p>
                        </div>
                        <div>
                            <a href="{{ route('events.create') }}" class="btn btn-light"><i class="bi bi-plus-circle me-2"></i>Create New Event</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase fw-semibold small">Total Events</h6>
                            <h2 class="mt-2 mb-0 display-6 fw-bold text-primary">{{ $totalEvents }}</h2>
                        </div>
                        <div class="p-2 rounded-circle bg-primary text-white">
                            <i class="bi bi-calendar-event fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Status Breakdown:</span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="badge bg-success">{{ $publishedEvents }} Published</span>
                            <span class="badge bg-warning text-dark">{{ $draftEvents }} Draft</span>
                            <span class="badge bg-danger">{{ $cancelledEvents }} Cancelled</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase fw-semibold small">Upcoming Events</h6>
                            <h2 class="mt-2 mb-0 display-6 fw-bold text-success">{{ $upcomingEvents }}</h2>
                        </div>
                        <div class="p-2 rounded-circle bg-success text-white">
                            <i class="bi bi-calendar-check fs-3"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 5px">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalEvents > 0 ? ($upcomingEvents / $totalEvents) * 100 : 0 }}%" aria-valuenow="{{ $upcomingEvents }}" aria-valuemin="0" aria-valuemax="{{ $totalEvents }}"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase fw-semibold small">Confirmed Registrations</h6>
                            <h2 class="mt-2 mb-0 display-6 fw-bold text-info">{{ $totalConfirmedRegistrations }}</h2>
                        </div>
                        <div class="p-2 rounded-circle bg-info text-white">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small">
                            <span class="badge bg-info">{{ $totalConfirmedRegistrations }} Active</span>
                            <span class="badge bg-secondary">{{ $pendingRegistrations }} Pending</span>
                            <span class="badge bg-danger">{{ $cancelledRegistrations }} Cancelled</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase fw-semibold small">Events at Capacity</h6>
                            <h2 class="mt-2 mb-0 display-6 fw-bold text-danger">{{ $fullEvents }}</h2>
                        </div>
                        <div class="p-2 rounded-circle bg-danger text-white">
                            <i class="bi bi-exclamation-triangle fs-3"></i>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 5px">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalEvents > 0 ? ($fullEvents / $totalEvents) * 100 : 0 }}%" aria-valuenow="{{ $fullEvents }}" aria-valuemin="0" aria-valuemax="{{ $totalEvents }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Status Chart & Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-8 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">Registration Status Overview</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="bg-light p-4 rounded text-center">
                        <!-- Canvas for chart (would require Chart.js in a real implementation) -->
                        <div class="d-flex justify-content-around align-items-center">
                            <div class="text-center p-3">
                                <div class="rounded-circle bg-secondary text-white mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <span class="h4 mb-0">{{ $pendingRegistrations }}</span>
                                </div>
                                <h6 class="mt-2">Pending</h6>
                            </div>
                            <div class="text-center p-3">
                                <div class="rounded-circle bg-success text-white mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <span class="h4 mb-0">{{ $totalConfirmedRegistrations }}</span>
                                </div>
                                <h6 class="mt-2">Confirmed</h6>
                            </div>
                            <div class="text-center p-3">
                                <div class="rounded-circle bg-danger text-white mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <span class="h4 mb-0">{{ $cancelledRegistrations }}</span>
                                </div>
                                <h6 class="mt-2">Cancelled</h6>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3">
                        {{ $pendingRegistrations }} registrations need your attention. 
                        <a href="#" class="text-decoration-none">View all pending registrations</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('events.create') }}" class="btn btn-primary d-flex align-items-center justify-content-between">
                            <span>Create New Event</span>
                            <i class="bi bi-plus-circle"></i>
                        </a>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-between">
                            <span>Manage Events</span>
                            <i class="bi bi-gear"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Events and Registrations -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Events</h5>
                    <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Registrations</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEvents as $event)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3 text-primary">
                                                <i class="bi bi-calendar-event fs-4"></i>
                                            </div>
                                            <div>
                                                <p class="fw-bold mb-0">{{ $event->title }}</p>
                                                <p class="text-muted small mb-0">{{ Str::limit($event->location, 30) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="small">{{ $event->start_date->format('M d, Y') }}</span>
                                        <br>
                                        <span class="text-muted small">{{ $event->start_date->format('h:i A') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $event->status === 'published' ? 'success' : ($event->status === 'draft' ? 'warning' : 'danger') }} rounded-pill">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <span class="small">{{ $event->confirmedRegistrationsCount() }}/{{ $event->capacity }}</span>
                                            </div>
                                            <div style="width: 50px">
                                                <div class="progress" style="height: 6px">
                                                    <div class="progress-bar bg-{{ $event->isFull() ? 'danger' : 'success' }}" role="progressbar" 
                                                        style="width: {{ $event->capacity > 0 ? min(100, ($event->confirmedRegistrationsCount() / $event->capacity) * 100) : 0 }}%" 
                                                        aria-valuenow="{{ $event->confirmedRegistrationsCount() }}" aria-valuemin="0" aria-valuemax="{{ $event->capacity }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary">View</a>
                                            <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-secondary">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">No events available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Registrations</h5>
                    <div>
                        <select class="form-select form-select-sm" id="registrationFilter">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="registrationsTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRegistrations as $reg)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light text-secondary d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                <span>{{ substr($reg->user->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="fw-bold mb-0">{{ $reg->user->name ?? 'N/A' }}</p>
                                                <p class="text-muted small mb-0">{{ $reg->user->email ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('events.show', $reg->event) }}" class="text-decoration-none">
                                            {{ Str::limit($reg->event->title ?? 'N/A', 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $reg->status === 'pending' ? 'secondary' : ($reg->status === 'confirmed' ? 'success' : 'danger') }} rounded-pill" data-status="{{ $reg->status }}">
                                            {{ ucfirst($reg->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="small">{{ $reg->created_at->format('M d') }}</span>
                                        <br>
                                        <span class="text-muted small">{{ $reg->created_at->format('h:i A') }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('events.registrations.update-status', [$reg->event, $reg]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <div class="btn-group btn-group-sm">
                                                @if($reg->status === 'pending')
                                                <button type="submit" name="status" value="confirmed" class="btn btn-outline-success">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                                <button type="submit" name="status" value="cancelled" class="btn btn-outline-danger">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                                @else
                                                <a href="{{ route('events.show', $reg->event) }}" class="btn btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">No registrations available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Add JavaScript for Registration Status Filter -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('registrationFilter');
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                const selectedStatus = this.value.toLowerCase();
                const regRows = document.querySelectorAll('#registrationsTable tbody tr');
                
                regRows.forEach(row => {
                    if (selectedStatus === 'all') {
                        row.style.display = '';
                    } else {
                        const statusCell = row.querySelector('[data-status]');
                        if (statusCell) {
                            const rowStatus = statusCell.getAttribute('data-status').toLowerCase();
                            row.style.display = (rowStatus === selectedStatus) ? '' : 'none';
                        }
                    }
                });
            });
        }
    });
</script>

@endsection 