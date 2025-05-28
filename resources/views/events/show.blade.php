@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Event Details Card -->
            <div class="card shadow-sm rounded-3 border-0 mb-4">
                <!-- Card Header with Event Title and Admin Actions -->
                <div class="card-header bg-primary text-white p-4 rounded-top-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="fs-2 fw-bold mb-0">{{ $event->title }}</h1>
                        @if(Auth::user()->role === 'admin')
                            <div class="d-flex gap-2">
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this event?')">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card Body with Event Details -->
                <div class="card-body p-4">
                    <!-- Alerts -->
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

                    <!-- Event Overview -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100 bg-light border-0 rounded-3">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-3">
                                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Event Details
                                    </h5>
                                    <ul class="list-group list-group-flush bg-transparent">
                                        <li class="list-group-item bg-transparent px-0 py-2 d-flex border-0 border-bottom">
                                            <div class="text-muted me-2 w-25">Start:</div>
                                            <div class="fw-semibold">{{ $event->start_date->format('M d, Y H:i') }}</div>
                                        </li>
                                        <li class="list-group-item bg-transparent px-0 py-2 d-flex border-0 border-bottom">
                                            <div class="text-muted me-2 w-25">End:</div>
                                            <div class="fw-semibold">{{ $event->end_date->format('M d, Y H:i') }}</div>
                                        </li>
                                        <li class="list-group-item bg-transparent px-0 py-2 d-flex border-0 border-bottom">
                                            <div class="text-muted me-2 w-25">Location:</div>
                                            <div class="fw-semibold">{{ $event->location }}</div>
                                        </li>
                                        <li class="list-group-item bg-transparent px-0 py-2 d-flex border-0">
                                            <div class="text-muted me-2 w-25">Status:</div>
                                            <div>
                                                <span class="badge bg-{{ $event->status === 'published' ? 'success' : ($event->status === 'draft' ? 'warning text-dark' : 'danger') }}">
                                                    {{ ucfirst($event->status) }}
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 bg-light border-0 rounded-3">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-3">
                                        <i class="bi bi-people-fill text-primary me-2"></i>Registration Status
                                    </h5>
                                    
                                    <div class="text-center mb-3">
                                        @php
                                            $registrationPercent = $event->capacity > 0 ? 
                                                min(100, round(($event->confirmedRegistrationsCount() / $event->capacity) * 100)) : 0;
                                        @endphp
                                        
                                        <div class="position-relative d-inline-block mb-2" style="width: 120px; height: 120px;">
                                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                                <h3 class="mb-0 fw-bold">{{ $registrationPercent }}%</h3>
                                                <div class="small text-muted">Full</div>
                                            </div>
                                            <svg width="120" height="120" viewBox="0 0 120 120">
                                                <circle cx="60" cy="60" r="54" fill="none" stroke="#e9ecef" stroke-width="12" />
                                                <circle cx="60" cy="60" r="54" fill="none" stroke="{{ $registrationPercent >= 80 ? '#dc3545' : '#198754' }}" 
                                                    stroke-width="12"
                                                    stroke-dasharray="339.292"
                                                    stroke-dashoffset="{{ 339.292 * (1 - $registrationPercent/100) }}"
                                                    transform="rotate(-90 60 60)" />
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <h5 class="fw-bold">{{ $event->confirmedRegistrationsCount() }} / {{ $event->capacity }}</h5>
                                        <p class="text-muted mb-0">Confirmed Registrations</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Description -->
                    <div class="mb-4">
                        <h5 class="fw-bold border-bottom pb-2 mb-3">
                            <i class="bi bi-file-text-fill text-primary me-2"></i>Description
                        </h5>
                        <div class="p-3 bg-light rounded-3">
                            <p class="mb-0">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Registration Card -->
            @if(Auth::user()->role !== 'admin')
                <div class="card shadow-sm rounded-3 border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold border-bottom pb-2 mb-3">
                            <i class="bi bi-ticket-perforated-fill text-primary me-2"></i>Registration
                        </h5>
                        
                        @if(!$registration)
                            @if($event->status === 'published' && !$event->isFull())
                                <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3">
                                    <div class="text-success fs-3">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Registration is open!</h6>
                                        <p class="mb-0 text-muted">Reserve your spot now before it fills up.</p>
                                    </div>
                                    <div class="ms-auto">
                                        <form action="{{ route('events.register', $event) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle me-2"></i>Register Now
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @elseif($event->isFull())
                                <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3">
                                    <div class="text-danger fs-3">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Registration is full</h6>
                                        <p class="mb-0 text-muted">Unfortunately, this event has reached its capacity.</p>
                                    </div>
                                </div>
                            @elseif($event->status === 'cancelled')
                                <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3">
                                    <div class="text-danger fs-3">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Event cancelled</h6>
                                        <p class="mb-0 text-muted">This event has been cancelled.</p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="alert mb-0 d-flex align-items-center gap-3 p-3 
                                @if($registration->status === 'pending') alert-warning
                                @elseif($registration->status === 'confirmed') alert-success
                                @elseif($registration->status === 'cancelled') alert-danger
                                @endif">
                                <div class="fs-3">
                                    @if($registration->status === 'pending')
                                        <i class="bi bi-hourglass-split"></i>
                                    @elseif($registration->status === 'confirmed')
                                        <i class="bi bi-check-circle-fill"></i>
                                    @elseif($registration->status === 'cancelled')
                                        <i class="bi bi-x-circle-fill"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    @if($registration->status === 'pending')
                                        <h5 class="mb-1">Your registration is pending</h5>
                                        <p class="mb-0">Please wait for admin confirmation.</p>
                                    @elseif($registration->status === 'confirmed')
                                        <h5 class="mb-1">Your registration is confirmed!</h5>
                                        <p class="mb-0">We look forward to seeing you.</p>
                                    @elseif($registration->status === 'cancelled')
                                        <h5 class="mb-1">Your registration has been cancelled</h5>
                                        <p class="mb-0">You will not be able to attend this event.</p>
                                    @endif
                                </div>
                                
                                @if($registration->status === 'pending' || $registration->status === 'confirmed')
                                    <div>
                                        <form action="{{ route('events.cancel-registration', $event) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to cancel your registration?')">
                                                <i class="bi bi-x-circle me-2"></i>Cancel Registration
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Admin Sidebar or Additional Information -->
        <div class="col-lg-4">
            @if(Auth::user()->role === 'admin' && isset($registrations))
                <!-- Registrations Management Card for Admin -->
                <div class="card shadow-sm rounded-3 border-0 mb-4">
                    <div class="card-header bg-light border-0">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-people-fill text-primary me-2"></i>Registered Clients
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($registrations->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th class="pe-3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registrations as $reg)
                                            <tr>
                                                <td class="ps-3">{{ $reg->user->name ?? 'N/A' }}</td>
                                                <td>{{ $reg->user->email ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-
                                                        @if($reg->status === 'pending') warning text-dark
                                                        @elseif($reg->status === 'confirmed') success
                                                        @elseif($reg->status === 'cancelled') danger
                                                        @endif
                                                    ">
                                                        {{ ucfirst($reg->status) }}
                                                    </span>
                                                </td>
                                                <td class="pe-3">
                                                    <form method="POST" action="{{ route('events.registrations.update-status', [$event, $reg]) }}" class="d-flex align-items-center gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status" class="form-select form-select-sm" style="width:auto;">
                                                            <option value="pending" {{ $reg->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="confirmed" {{ $reg->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                            <option value="cancelled" {{ $reg->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-people text-muted mb-3" style="font-size: 2rem;"></i>
                                <p class="mb-0">No registrations yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Action Card -->
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header bg-light border-0">
                    <h5 class="fw-bold mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Events
                        </a>
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                                <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 