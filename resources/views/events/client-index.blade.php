@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Hero Section -->
    <div class="card bg-primary text-white mb-4 shadow-sm rounded-3 border-0">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-2">Available Events</h1>
                    <p class="lead mb-0">Discover and register for upcoming events that match your interests</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="d-inline-block">
                        <form action="{{ route('events.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Search events..." 
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-light ms-2">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if (session('success'))
        <div class="alert alert-success shadow-sm" role="alert">
            <div class="d-flex">
                <div class="me-2">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm" role="alert">
            <div class="d-flex">
                <div class="me-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div>
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Events Grid with Sidebar -->
    <div class="row g-4">
        <!-- Sidebar with Filters -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0 fw-bold">Filter Events</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.index') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date Range</label>
                            <select name="date_range" class="form-select">
                                <option value="">All Dates</option>
                                <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm rounded-3 border-0 mt-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Need Help?</h5>
                    <p class="text-muted mb-3">If you have questions about any of our events or registration process, please contact us.</p>
                    <div class="d-grid">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="bi bi-question-circle me-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Events Grid -->
        <div class="col-lg-9">
            @if($events->count() > 0)
                <div class="row g-4">
                    @foreach($events as $event)
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 shadow-sm hover-card border-0 rounded-3">
                                <div class="position-relative">
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center py-4" style="height: 150px;">
                                        <i class="bi bi-calendar-event text-primary" style="font-size: 3rem;"></i>
                                    </div>
                                    @if($event->isFull())
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-danger">FULL</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">{{ $event->title }}</h5>
                                    <div class="text-muted mb-2 small">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bi bi-calendar3 me-2"></i>
                                            {{ $event->start_date->format('M d, Y H:i') }}
                                        </div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bi bi-geo-alt me-2"></i>
                                            {{ $event->location }}
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-people me-2"></i>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                @php
                                                    $registrationPercent = $event->capacity > 0 ? 
                                                        min(100, round(($event->confirmedRegistrationsCount() / $event->capacity) * 100)) : 0;
                                                @endphp
                                                <div class="progress-bar {{ $registrationPercent >= 80 ? 'bg-danger' : 'bg-success' }}" 
                                                    role="progressbar" style="width: {{ $registrationPercent }}%"></div>
                                            </div>
                                            <span class="ms-2 small">{{ $event->confirmedRegistrationsCount() }}/{{ $event->capacity }}</span>
                                        </div>
                                    </div>
                                    <p class="card-text flex-grow-1">{{ Str::limit($event->description, 100) }}</p>
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-primary mt-2">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $events->links() }}
                </div>
            @else
                <div class="card shadow-sm rounded-3 border-0">
                    <div class="card-body py-5 text-center">
                        <i class="bi bi-calendar-x text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4>No events available</h4>
                        <p class="text-muted">There are no upcoming events available at the moment.</p>
                        <p>Please check back later or contact the administrator for more information.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 