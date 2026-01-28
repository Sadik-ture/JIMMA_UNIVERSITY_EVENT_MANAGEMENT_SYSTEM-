<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\EventRequestController;
use App\Http\Controllers\GuestEventController;

// Public Routes - Homepage shows Guest Event Dashboard (NO login required)
Route::get('/', [GuestEventController::class, 'dashboard'])->name('home');

// Guest Event Routes (Public - No authentication required)
Route::prefix('events')->name('events.guest.')->group(function () {
    Route::get('/', [GuestEventController::class, 'dashboard'])->name('dashboard');
    Route::get('/{event}', [GuestEventController::class, 'show'])->name('show');
    Route::get('/{event}/share', [GuestEventController::class, 'share'])->name('share');
});

// Authentication Routes (separate pages)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected Routes (Require authentication - only accessible after login)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin Dashboard (separate from home)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::resource('users', UserController::class);
    
    // Roles Management
    Route::resource('roles', RoleController::class);
    
    // Permissions Management
    Route::resource('permissions', PermissionController::class);
    
    // Admin Events Management (different from guest events)
    Route::prefix('admin')->group(function () {
        Route::resource('events', EventController::class)->names([
            'index' => 'admin.events.index',
            'create' => 'admin.events.create',
            'store' => 'admin.events.store',
            'show' => 'admin.events.show',
            'edit' => 'admin.events.edit',
            'update' => 'admin.events.update',
            'destroy' => 'admin.events.destroy'
        ]);
        Route::post('events/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])
            ->name('admin.events.toggle-featured');
    });
    
    // Speakers Management
    Route::resource('speakers', SpeakerController::class);
    Route::post('speakers/{speaker}/toggle-active', [SpeakerController::class, 'toggleActive'])
        ->name('speakers.toggle-active');
    Route::post('speakers/{speaker}/toggle-featured', [SpeakerController::class, 'toggleFeatured'])
        ->name('speakers.toggle-featured');
    
    // Event Requests Management
    Route::resource('event-requests', EventRequestController::class);
    
    // Event Request Actions
    Route::post('/event-requests/{eventRequest}/cancel', [EventRequestController::class, 'cancel'])
        ->name('event-requests.cancel');
    Route::post('/event-requests/{eventRequest}/approve', [EventRequestController::class, 'approve'])
        ->name('event-requests.approve');
    Route::post('/event-requests/{eventRequest}/reject', [EventRequestController::class, 'reject'])
        ->name('event-requests.reject');
});

// REMOVED THE DUPLICATE ROUTES AT THE END
// Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
// Route::resource('events', EventController::class);