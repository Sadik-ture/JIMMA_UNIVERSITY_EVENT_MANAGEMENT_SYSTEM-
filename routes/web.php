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
use App\Http\Controllers\ProfileController;

// =============== PUBLIC ROUTES ===============
Route::prefix('events')->name('events.guest.')->group(function () {
    Route::get('/', [GuestEventController::class, 'dashboard'])->name('dashboard');
    Route::get('/browse', [GuestEventController::class, 'browse'])->name('browse');
    Route::get('/{slug}', [GuestEventController::class, 'show'])->name('show');
    Route::get('/{slug}/share', [GuestEventController::class, 'share'])->name('share');
    Route::get('/{slug}/export/ics', [GuestEventController::class, 'exportIcs'])->name('export-ics');
});

Route::get('/', [GuestEventController::class, 'dashboard'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// =============== PROTECTED ROUTES ===============
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // =============== ADMIN DASHBOARD - PROTECTED ===============
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Load role if needed
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }
        
        // Check if user has admin role - ADJUST THESE SLUGS BASED ON YOUR DATABASE
        $adminSlugs = ['super-admin', 'admin', 'administrator'];
        
        if (!$user->role || !in_array($user->role->slug, $adminSlugs)) {
            abort(403, 'Unauthorized. Admin access only.');
        }
        
        return app(DashboardController::class)->index();
    })->name('dashboard');

    Route::get('/dashboard/stats', function () {
        $user = auth()->user();
        
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }
        
        $adminSlugs = ['super-admin', 'admin', 'administrator'];
        
        if (!$user->role || !in_array($user->role->slug, $adminSlugs)) {
            abort(403, 'Unauthorized. Admin access only.');
        }
        
        return app(DashboardController::class)->getDashboardStats();
    })->name('dashboard.stats');

    // =============== USER MANAGEMENT ===============
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    // =============== EVENT MANAGEMENT ===============
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('events', EventController::class);
        Route::post('events/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])
            ->name('events.toggle-featured');
        Route::post('events/{event}/toggle-public', [EventController::class, 'togglePublic'])
            ->name('events.toggle-public');
        Route::post('events/{event}/duplicate', [EventController::class, 'duplicate'])
            ->name('events.duplicate');
        Route::get('events/export', [EventController::class, 'export'])
            ->name('events.export');

        Route::resource('campuses', CampusController::class);
        Route::post('campuses/{campus}/toggle-active', [CampusController::class, 'toggleActive'])
            ->name('campuses.toggle-active');

        Route::resource('buildings', BuildingController::class);
        Route::post('buildings/{building}/toggle-active', [BuildingController::class, 'toggleActive'])
            ->name('buildings.toggle-active');

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
    Route::get('/my-event-requests', [EventRequestController::class, 'myRequests'])
        ->name('event-requests.my-requests');
    
    Route::resource('event-requests', EventRequestController::class);

    Route::post('/event-requests/{eventRequest}/cancel', [EventRequestController::class, 'cancel'])
        ->name('event-requests.cancel');
    Route::post('/event-requests/{eventRequest}/approve', [EventRequestController::class, 'approve'])
        ->name('event-requests.approve');
    Route::post('/event-requests/{eventRequest}/reject', [EventRequestController::class, 'reject'])
        ->name('event-requests.reject');

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
    Route::prefix('notifications')->name('notifications.')->group(function () {
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

    // =============== PROFILE ROUTES ===============
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
        Route::delete('/photo', [ProfileController::class, 'destroyPhoto'])->name('photo.destroy');
        Route::put('/password', [ProfileController::class, 'changePassword'])->name('password');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// =============== ANNOUNCEMENT ROUTES ===============
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/create', [AnnouncementController::class, 'create'])
    ->name('announcements.create')
    ->middleware('auth');
Route::get('/announcements/statistics', [AnnouncementController::class, 'statistics'])
    ->name('announcements.statistics')
    ->middleware('auth');
Route::post('/announcements', [AnnouncementController::class, 'store'])
    ->name('announcements.store')
    ->middleware('auth');
Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])
    ->name('announcements.show');
Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])
    ->name('announcements.edit')
    ->middleware('auth');
Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])
    ->name('announcements.update')
    ->middleware('auth');
Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])
    ->name('announcements.destroy')
    ->middleware('auth');
Route::post('/announcements/{id}/toggle-publish', [AnnouncementController::class, 'togglePublish'])
    ->name('announcements.toggle-publish')
    ->middleware('auth');
Route::post('/announcements/{id}/send-notification', [AnnouncementController::class, 'sendNotification'])
    ->name('announcements.send-notification')
    ->middleware('auth');

// =============== FEEDBACK ROUTES ===============
Route::prefix('feedback')->name('feedback.')->group(function () {
    Route::get('/create', [FeedbackController::class, 'create'])->name('create');
    Route::post('/', [FeedbackController::class, 'store'])->name('store');
    Route::get('/thankyou', [FeedbackController::class, 'thankyou'])->name('thankyou');
    Route::get('/testimonials', [FeedbackController::class, 'testimonials'])->name('testimonials');

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