@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">Welcome, {{ Auth::user()->name }}!</h2>
                            <p class="mb-0">Explore upcoming events and manage your registrations</p>
                        </div>
                        <div>
                            <a href="{{ route('events.index') }}" class="btn btn-light">
                                <i class="bi bi-calendar-event me-2"></i>Browse Events
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Your Registrations</h5>
                    <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-primary">View All Events</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($registrations) && $registrations->count() > 0)
                                    @foreach($registrations as $registration)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3 text-primary">
                                                        <i class="bi bi-calendar-event fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <p class="fw-bold mb-0">{{ $registration->event->title }}</p>
                                                        <p class="text-muted small mb-0">{{ Str::limit($registration->event->location, 30) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="small">{{ $registration->event->start_date->format('M d, Y') }}</span>
                                                <br>
                                                <span class="text-muted small">{{ $registration->event->start_date->format('h:i A') }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $registration->status === 'pending' ? 'secondary' : ($registration->status === 'confirmed' ? 'success' : 'danger') }} rounded-pill">
                                                    {{ ucfirst($registration->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('events.show', $registration->event) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                                
                                                @if($registration->status !== 'cancelled')
                                                    <form action="{{ route('events.cancel-registration', $registration->event) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to cancel your registration?')">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="mb-0 text-muted">You haven't registered for any events yet.</p>
                                            <a href="{{ route('events.index') }}" class="btn btn-primary mt-2">Browse Available Events</a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Your Profile</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="h5 mb-0">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                            <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            <i class="bi bi-person me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Quick Links</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-calendar-event me-2"></i>Browse Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 