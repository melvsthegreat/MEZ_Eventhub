<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403);
        }

        // Total events and breakdown by status
        $totalEvents = Event::count();
        $publishedEvents = Event::where('status', 'published')->count();
        $draftEvents = Event::where('status', 'draft')->count();
        $cancelledEvents = Event::where('status', 'cancelled')->count();
        
        // Upcoming events (published and in the future)
        $upcomingEvents = Event::where('status', 'published')
            ->where('start_date', '>', now())
            ->count();
            
        // Registration stats
        $totalConfirmedRegistrations = EventRegistration::where('status', 'confirmed')->count();
        $pendingRegistrations = EventRegistration::where('status', 'pending')->count();
        $cancelledRegistrations = EventRegistration::where('status', 'cancelled')->count();
        
        // Full events
        $fullEvents = Event::all()->filter(fn($e) => $e->isFull())->count();

        // Recent items
        $recentRegistrations = EventRegistration::with(['user', 'event'])
            ->latest()
            ->take(5)
            ->get();
        $recentEvents = Event::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'publishedEvents',
            'draftEvents',
            'cancelledEvents',
            'upcomingEvents',
            'totalConfirmedRegistrations',
            'pendingRegistrations',
            'cancelledRegistrations',
            'fullEvents',
            'recentRegistrations',
            'recentEvents'
        ));
    }
}
