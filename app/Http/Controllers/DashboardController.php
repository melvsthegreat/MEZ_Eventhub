<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Get client's event registrations
        $registrations = EventRegistration::with('event')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get upcoming events they might be interested in
        $upcomingEvents = Event::where('status', 'published')
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();
            
        return view('dashboard.client', compact('registrations', 'upcomingEvents'));
    }
}
