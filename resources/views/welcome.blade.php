<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MEZ EventHub') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .hero-section {
                background: linear-gradient(135deg, #262248 0%, #3a3465 100%);
                color: white;
                position: relative;
                overflow: hidden;
            }

            .hero-pattern {
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='rgba(255,255,255,.05)' fill-rule='evenodd'/%3E%3C/svg%3E");
                opacity: 0.3;
                z-index: 0;
            }

            .feature-icon {
                width: 4rem;
                height: 4rem;
                border-radius: 0.75rem;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                color: white;
                margin-bottom: 1rem;
            }

            .bg-primary-gradient {
                background: linear-gradient(135deg, #262248 0%, #3a3465 100%);
            }

            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }

            .btn-primary {
                background-color: #262248;
                border-color: #262248;
            }

            .btn-primary:hover {
                background-color: #3a3465;
                border-color: #3a3465;
            }

            .btn-outline-primary {
                color: #262248;
                border-color: #262248;
            }

            .btn-outline-primary:hover {
                background-color: #262248;
                border-color: #262248;
            }

            .testimonial-avatar {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover;
            }

            .footer {
                background-color: #1a1831;
                color: rgba(255,255,255,0.7);
            }
        </style>
    </head>
    <body class="antialiased">
        <header class="bg-white shadow-sm py-3">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/" class="d-flex align-items-center text-decoration-none">
                        <img src="{{ asset('images/mez-eventhub-logo.svg') }}" alt="MEZ EventHub" height="60">
                    </a>
                    <div>
                        @if (Route::has('login'))
                            <div>
                                @auth
                                    @if (Auth::user()->role === 'admin')
                                        <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary">Dashboard</a>
                                    @else
                                        <a href="{{ url('/events') }}" class="btn btn-primary">My Events</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Log in</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="hero-section py-5">
                <div class="hero-pattern"></div>
                <div class="container py-5 position-relative">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-5 mb-lg-0">
                            <h1 class="display-4 fw-bold mb-4">Modern Event Management Made Simple</h1>
                            <p class="lead mb-4">Plan, organize, and manage your events with MEZ EventHub - the complete solution for event professionals.</p>
                            <div class="d-flex gap-3">
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">Get Started</a>
                                @endif
                                <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg">Explore Events</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Event Management" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="py-5 bg-light">
                <div class="container py-5">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold">Everything You Need for Successful Events</h2>
                        <p class="lead text-muted">Powerful tools to streamline your event management process</p>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm card-hover transition-all">
                                <div class="card-body p-4">
                                    <div class="feature-icon bg-primary-gradient">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <h3 class="h4 mb-3">Event Planning</h3>
                                    <p class="text-muted">Create and manage events with powerful planning tools. Set up schedules, manage resources, and organize everything in one place.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm card-hover transition-all">
                                <div class="card-body p-4">
                                    <div class="feature-icon bg-primary-gradient">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <h3 class="h4 mb-3">Registration Management</h3>
                                    <p class="text-muted">Streamline the attendee registration process. Track registrations, send confirmations, and manage attendance all in one platform.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm card-hover transition-all">
                                <div class="card-body p-4">
                                    <div class="feature-icon bg-primary-gradient">
                                        <i class="bi bi-graph-up"></i>
                                    </div>
                                    <h3 class="h4 mb-3">Insightful Analytics</h3>
                                    <p class="text-muted">Get detailed insights into your events with comprehensive analytics and reporting. Make data-driven decisions to improve future events.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- How It Works Section -->
            <section class="py-5">
                <div class="container py-5">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold">How MEZ EventHub Works</h2>
                        <p class="lead text-muted">Simple steps to manage your events effectively</p>
                    </div>
                    
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Event Planning" class="img-fluid rounded-4 shadow">
                        </div>
                        <div class="col-lg-6">
                            <div class="ms-lg-4">
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 bg-primary-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">1</span>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="h4">Create Your Event</h3>
                                        <p class="text-muted">Set up your event details including name, description, date, time, location, and capacity.</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 bg-primary-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">2</span>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="h4">Manage Registrations</h3>
                                        <p class="text-muted">Accept and review registrations, communicate with attendees, and manage event capacity.</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 bg-primary-gradient text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">3</span>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="h4">Track & Analyze</h3>
                                        <p class="text-muted">Monitor event progress, gather feedback, and analyze performance with detailed metrics.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-5 bg-primary-gradient text-white">
                <div class="container py-5 text-center">
                    <h2 class="display-5 fw-bold mb-4">Ready to Create Your Next Event?</h2>
                    <p class="lead mb-4">Join thousands of event planners already using MEZ EventHub</p>
                    <div class="d-flex justify-content-center gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Sign Up Now</a>
                        @endif
                        <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-lg px-4">Explore Events</a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <img src="{{ asset('images/mez-eventhub-logo.svg') }}" alt="MEZ EventHub" height="60" class="mb-4">
                        <p>MEZ EventHub makes event management simple and efficient. Create, manage, and track your events all in one powerful platform.</p>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                        <h5 class="text-white mb-4">Platform</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Features</a></li>
                            <li class="mb-2"><a href="#" class="text-reset text-decoration-none">How It Works</a></li>
                            <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Pricing</a></li>
                            <li class="mb-2"><a href="#" class="text-reset text-decoration-none">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                        <h5 class="text-white mb-4">Company</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-reset text-decoration-none">About</a></li>
                            <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Team</a></li>
                            <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Careers</a></li>
                            <li class="mb-2"><a href="#" class="text-reset text-decoration-none">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <h5 class="text-white mb-4">Stay Connected</h5>
                        <p>Subscribe to our newsletter for updates and event management tips.</p>
                        <form class="mb-3">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email">
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </div>
                        </form>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-reset fs-5"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="text-reset fs-5"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-reset fs-5"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="text-reset fs-5"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="mt-5 mb-4 border-secondary">
                <div class="text-center">
                    <p class="small mb-0">&copy; {{ date('Y') }} MEZ EventHub. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
