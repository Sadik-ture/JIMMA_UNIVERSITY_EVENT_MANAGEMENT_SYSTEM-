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
use App\Http\Controllers\CampusController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\FeedbackController;

// =============== PUBLIC ROUTES ===============
// Homepage - Guest Event Dashboard (NO login required)

// Guest Event Routes (Public - No authentication required)
Route::prefix('events')->name('events.guest.')->group(function () {
    Route::get('/', [GuestEventController::class, 'dashboard'])->name('dashboard');
    Route::get('/browse', [GuestEventController::class, 'browse'])->name('browse');
    Route::get('/{slug}', [GuestEventController::class, 'show'])->name('show');
    Route::get('/{slug}/share', [GuestEventController::class, 'share'])->name('share');
    Route::get('/{slug}/export/ics', [GuestEventController::class, 'exportIcs'])->name('export-ics');
});

// Update the homepage route
Route::get('/', [GuestEventController::class, 'dashboard'])->name('home');

// Dashboard route - admin only
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'can:view_dashboard']);

// Dashboard stats API - admin only
Route::get('/dashboard/stats', [DashboardController::class, 'getDashboardStats'])
    ->name('dashboard.stats')
    ->middleware(['auth', 'can:view_dashboard']);

// Authentication Routes (separate pages)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// =============== PROTECTED ROUTES (Require authentication) ===============
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =============== USER MANAGEMENT ===============
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    // =============== EVENT MANAGEMENT ===============
    Route::prefix('admin')->name('admin.')->group(function () {
        // Events
        Route::resource('events', EventController::class);
        Route::post('events/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])
            ->name('events.toggle-featured');
        Route::post('events/{event}/toggle-public', [EventController::class, 'togglePublic'])
            ->name('events.toggle-public');
        Route::post('events/{event}/duplicate', [EventController::class, 'duplicate'])
            ->name('events.duplicate');
        Route::get('events/export', [EventController::class, 'export'])
            ->name('events.export');

        // Campus Management
        Route::resource('campuses', CampusController::class);
        Route::post('campuses/{campus}/toggle-active', [CampusController::class, 'toggleActive'])
            ->name('campuses.toggle-active');

        // Building Management
        Route::resource('buildings', BuildingController::class);
        Route::post('buildings/{building}/toggle-active', [BuildingController::class, 'toggleActive'])
            ->name('buildings.toggle-active');

        // Venue Management
        Route::resource('venues', VenueController::class);
        Route::post('venues/{venue}/toggle-availability', [VenueController::class, 'toggleAvailability'])
            ->name('venues.toggle-availability');
    });

    // =============== SPEAKER MANAGEMENT ===============
    Route::resource('speakers', SpeakerController::class);
    Route::post('speakers/{speaker}/toggle-active', [SpeakerController::class, 'toggleActive'])
        ->name('speakers.toggle-active');
    Route::post('speakers/{speaker}/toggle-featured', [SpeakerController::class, 'toggleFeatured'])
        ->name('speakers.toggle-featured');

    // =============== EVENT REQUEST MANAGEMENT ===============
    // My Event Requests - USER'S OWN REQUESTS (ADD THIS ROUTE FIRST)
    Route::get('/my-event-requests', [EventRequestController::class, 'myRequests'])
        ->name('event-requests.my-requests');
    
    // Resource route for event requests
    Route::resource('event-requests', EventRequestController::class);

    // Regular form submission routes (POST)
    Route::post('/event-requests/{eventRequest}/cancel', [EventRequestController::class, 'cancel'])
        ->name('event-requests.cancel');
    Route::post('/event-requests/{eventRequest}/approve', [EventRequestController::class, 'approve'])
        ->name('event-requests.approve');
    Route::post('/event-requests/{eventRequest}/reject', [EventRequestController::class, 'reject'])
        ->name('event-requests.reject');

    // Quick AJAX routes (POST)
    Route::post('/event-requests/{eventRequest}/quick-approve', [EventRequestController::class, 'quickApprove'])
        ->name('event-requests.quick-approve');
    Route::post('/event-requests/{eventRequest}/quick-reject', [EventRequestController::class, 'quickReject'])
        ->name('event-requests.quick-reject');
    Route::post('/event-requests/{eventRequest}/quick-cancel', [EventRequestController::class, 'quickCancel'])
        ->name('event-requests.quick-cancel');

    // =============== EVENT REGISTRATION ===============
    Route::get('/register-for-events', [EventRegistrationController::class, 'index'])
        ->name('event-registration.index');
    Route::get('/events/{event}/register', [EventRegistrationController::class, 'create'])
        ->name('event-registration.create');
    Route::post('/events/{event}/register', [EventRegistrationController::class, 'store'])
        ->name('event-registration.store');
    Route::post('/events/{event}/cancel-registration', [EventRegistrationController::class, 'cancel'])
        ->name('event-registration.cancel');
    Route::get('/my-events', [EventRegistrationController::class, 'myEvents'])
        ->name('my-events.index');
    Route::get('/my-registrations/{registration}', [EventRegistrationController::class, 'show'])
        ->name('event-registration.show');
    Route::get('/events/{event}/participants', [EventRegistrationController::class, 'participants'])
        ->name('events.participants');
    Route::get('/events/{event}/participants/export-excel', [EventRegistrationController::class, 'exportExcel'])
        ->name('events.participants.export-excel');
    Route::get('/events/{event}/participants/export-pdf', [EventRegistrationController::class, 'exportPdf'])
        ->name('events.participants.export-pdf');
    Route::post('/registrations/{registration}/check-in', [EventRegistrationController::class, 'checkIn'])
        ->name('registrations.check-in');
    Route::post('/registrations/{registration}/update-status', [EventRegistrationController::class, 'updateStatus'])
        ->name('registrations.update-status');

    // =============== NOTIFICATION ROUTES ===============
    Route::prefix('notifications')->name('notifications.')->middleware(['auth'])->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/recent', [NotificationController::class, 'recent'])->name('recent');
        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
        Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::patch('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::patch('/{id}/dismiss', [NotificationController::class, 'dismiss'])->name('dismiss');
        Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('clear-all');
        Route::get('/sent', [NotificationController::class, 'sent'])->name('sent');
        Route::get('/send-custom', [NotificationController::class, 'sendCustom'])->name('send-custom');
        Route::post('/send-custom', [NotificationController::class, 'sendCustomStore'])->name('send-custom.store');
        Route::get('/statistics', [NotificationController::class, 'statistics'])->name('statistics');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });
});

// =============== ANNOUNCEMENT ROUTES ===============
// 1. Index (list all) - PUBLIC
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
// 2. Create form - PROTECTED
Route::get('/announcements/create', [AnnouncementController::class, 'create'])
    ->name('announcements.create')
    ->middleware('auth');
// 3. Statistics - PROTECTED
Route::get('/announcements/statistics', [AnnouncementController::class, 'statistics'])
    ->name('announcements.statistics')
    ->middleware('auth');
// 4. Store new announcement - PROTECTED
Route::post('/announcements', [AnnouncementController::class, 'store'])
    ->name('announcements.store')
    ->middleware('auth');
// 5. Show single announcement - PUBLIC
Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])
    ->name('announcements.show');
// 6. Edit form - PROTECTED
Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])
    ->name('announcements.edit')
    ->middleware('auth');
// 7. Update announcement - PROTECTED
Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])
    ->name('announcements.update')
    ->middleware('auth');
// 8. Delete announcement - PROTECTED
Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])
    ->name('announcements.destroy')
    ->middleware('auth');
// 9. Toggle publish - PROTECTED
Route::post('/announcements/{id}/toggle-publish', [AnnouncementController::class, 'togglePublish'])
    ->name('announcements.toggle-publish')
    ->middleware('auth');
// 10. Send notification for existing announcement - PROTECTED
Route::post('/announcements/{id}/send-notification', [AnnouncementController::class, 'sendNotification'])
    ->name('announcements.send-notification')
    ->middleware('auth');

// =============== FEEDBACK ROUTES ===============
Route::prefix('feedback')->name('feedback.')->group(function () {
    // =============== PUBLIC FEEDBACK ROUTES ===============
    Route::get('/create', [FeedbackController::class, 'create'])->name('create');
    Route::post('/', [FeedbackController::class, 'store'])->name('store');
    Route::get('/thankyou', [FeedbackController::class, 'thankyou'])->name('thankyou');
    Route::get('/testimonials', [FeedbackController::class, 'testimonials'])->name('testimonials');

    // =============== ADMIN FEEDBACK ROUTES ===============
    Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('index');
        Route::get('/{feedback}', [FeedbackController::class, 'show'])->name('show');
        Route::post('/{feedback}/update-status', [FeedbackController::class, 'updateStatus'])
            ->name('update-status');
        Route::post('/{feedback}/add-response', [FeedbackController::class, 'addResponse'])
            ->name('add-response');
        Route::post('/{feedback}/toggle-public', [FeedbackController::class, 'togglePublic'])
            ->name('toggle-public');
        Route::post('/{feedback}/toggle-featured', [FeedbackController::class, 'toggleFeatured'])
            ->name('toggle-featured');
        Route::get('/export/feedback', [FeedbackController::class, 'export'])->name('export');
        Route::get('/analytics', [FeedbackController::class, 'analytics'])->name('analytics');
    });
});

// =============== BACKWARD COMPATIBILITY ROUTES ===============
Route::middleware(['auth'])->group(function () {
    Route::get('/feedback/index', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/analytics', [FeedbackController::class, 'analytics'])->name('feedback.analytics');
    Route::get('/feedback/export', [FeedbackController::class, 'export'])->name('feedback.export');
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::post('/feedback/{feedback}/update-status', [FeedbackController::class, 'updateStatus'])
        ->name('feedback.update-status');
    Route::post('/feedback/{feedback}/add-response', [FeedbackController::class, 'addResponse'])
        ->name('feedback.add-response');
    Route::post('/feedback/{feedback}/toggle-public', [FeedbackController::class, 'togglePublic'])
        ->name('feedback.toggle-public');
    Route::post('/feedback/{feedback}/toggle-featured', [FeedbackController::class, 'toggleFeatured'])
        ->name('feedback.toggle-featured');
});

// =============== PUBLIC API ROUTES ===============
Route::get('/admin/buildings/by-campus/{campusId}', [BuildingController::class, 'getBuildingsByCampus'])
    ->name('admin.buildings.by-campus');
Route::get('/admin/events/get-venues/{buildingId}', [EventController::class, 'getVenues'])
    ->name('events.get-venues');
Route::get('/admin/events/get-buildings/{campusId}', [EventController::class, 'getBuildings'])
    ->name('events.get-buildings');
Route::get('/admin/events/get-venue-details/{venueId}', [EventController::class, 'getVenueDetails'])
    ->name('events.get-venue-details');
Route::get('/admin/buildings/get-by-campus/{campusId}', [BuildingController::class, 'getBuildingsByCampus'])
    ->name('buildings.get-by-campus');

// =============== FALLBACK ROUTE ===============
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});