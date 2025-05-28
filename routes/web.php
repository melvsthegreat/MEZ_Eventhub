<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Client routes
    Route::middleware(['role:client'])->group(function () {
        Route::resource('transactions', App\Http\Controllers\TransactionController::class)
            ->only(['index', 'create', 'store']);
    });

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('transactions', App\Http\Controllers\TransactionController::class)
            ->only(['index']);
    });

    // Admin dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard-redirect', [ProfileController::class, 'redirectToDashboard'])->name('dashboard.redirect');
});

// Event Management Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('events', EventController::class);
    Route::post('events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('events/{event}/cancel-registration', [EventController::class, 'cancelRegistration'])->name('events.cancel-registration');
    Route::patch('events/{event}/registrations/{registration}/status', [EventController::class, 'updateRegistrationStatus'])->name('events.registrations.update-status');
});

require __DIR__.'/auth.php';
