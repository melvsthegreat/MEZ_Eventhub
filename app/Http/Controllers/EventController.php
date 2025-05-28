<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $events = Event::with('registrations')->latest()->paginate(10);
            return view('events.admin-index', compact('events'));
        }

        $query = Event::where('status', 'published')
            ->where('start_date', '>', now());
            
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        // Apply date range filter if provided
        if ($request->filled('date_range')) {
            $range = $request->input('date_range');
            
            if ($range === 'today') {
                $query->whereDate('start_date', now()->toDateString());
            } elseif ($range === 'week') {
                $query->whereBetween('start_date', [
                    now()->startOfWeek()->toDateTimeString(),
                    now()->endOfWeek()->toDateTimeString()
                ]);
            } elseif ($range === 'month') {
                $query->whereBetween('start_date', [
                    now()->startOfMonth()->toDateTimeString(), 
                    now()->endOfMonth()->toDateTimeString()
                ]);
            }
        }
        
        $events = $query->latest()->paginate(10)->withQueryString();
        return view('events.client-index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
        ]);

        $event = Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $user = Auth::user();
        $registration = null;
        $registrations = null;

        if ($user->role !== 'admin') {
            $registration = $event->registrations()
                ->where('user_id', $user->id)
                ->first();
        } else {
            // Load all registrations with user info for admin
            $registrations = $event->registrations()->with('user')->get();
        }

        return view('events.show', compact('event', 'registration', 'registrations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function register(Event $event)
    {
        $user = Auth::user();

        if ($event->isFull()) {
            return back()->with('error', 'Event is full.');
        }

        if ($event->registrations()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You are already registered for this event.');
        }

        $event->registrations()->create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $event->increment('registered_count');

        return back()->with('success', 'Registration successful.');
    }

    public function cancelRegistration(Event $event)
    {
        $user = Auth::user();
        $registration = $event->registrations()
            ->where('user_id', $user->id)
            ->first();

        if (!$registration) {
            return back()->with('error', 'No registration found.');
        }

        $registration->update(['status' => 'cancelled']);
        $event->decrement('registered_count');

        return back()->with('success', 'Registration cancelled successfully.');
    }

    public function updateRegistrationStatus(Request $request, Event $event, EventRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,attended',
        ]);
        $registration->status = $request->status;
        $registration->save();
        return back()->with('success', 'Registration status updated.');
    }
}
