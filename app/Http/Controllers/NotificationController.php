<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\UserNotification;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display ONLY the user's own notifications
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get user's notifications through the pivot table with eager loading
        $query = $user->notifications()
            ->with(['sender', 'event'])
            ->orderBy('user_notifications.created_at', 'desc');
        
        // Filter by read status if provided
        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->whereNotNull('user_notifications.read_at');
            } elseif ($request->status === 'unread') {
                $query->whereNull('user_notifications.read_at');
            }
        }
        
        // Filter by type if provided
        if ($request->filled('type')) {
            $query->where('notifications.type', $request->type);
        }
        
        $notifications = $query->paginate(15);
        
        // Get unread count directly from pivot table
        $unreadCount = $user->userNotifications()->whereNull('read_at')->count();
        
        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($notificationId)
    {
        try {
            // Find the user's specific notification entry
            $userNotification = UserNotification::where('user_id', Auth::id())
                ->where('notification_id', $notificationId)
                ->firstOrFail();
            
            if (!$userNotification->read_at) {
                $userNotification->update(['read_at' => now()]);
            }
            
            $unreadCount = Auth::user()->userNotifications()->whereNull('read_at')->count();
            
            return response()->json([
                'success' => true,
                'unread_count' => $unreadCount,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found',
            ], 404);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        UserNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
            'unread_count' => 0,
        ]);
    }

    /**
     * Delete a user's notification
     */
    public function destroy($notificationId)
    {
        try {
            // Check if user has permission to manage notifications
            if (!Auth::user()->hasPermission('manage_notifications')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to delete notifications.',
                ], 403);
            }
            
            // Delete only the user's link to the notification, not the notification itself
            $deleted = UserNotification::where('user_id', Auth::id())
                ->where('notification_id', $notificationId)
                ->delete();
            
            if ($deleted) {
                $unreadCount = Auth::user()->userNotifications()->whereNull('read_at')->count();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Notification deleted',
                    'unread_count' => $unreadCount,
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Notification not found',
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting notification',
            ], 500);
        }
    }

    /**
     * Send custom notification (Admin only)
     */
    public function sendCustom()
    {
        $user = Auth::user();
        
        Log::info("sendCustom accessed by user: " . $user->id, [
            'user' => $user->name,
            'has_send_notifications' => $user->hasPermission('send_notifications'),
            'has_manage_notifications' => $user->hasPermission('manage_notifications'),
            'is_super_admin' => $user->hasRole('super-admin'),
            'is_admin' => $user->isAdmin()
        ]);
        
        // FIXED: Allow access for users with notification permissions OR admin
        if (!$user->hasPermission('send_notifications') && 
            !$user->hasPermission('manage_notifications') &&
            !$user->isAdmin()) {
            
            Log::warning("Permission denied for sendCustom", [
                'user_id' => $user->id,
                'send_notifications_permission' => $user->hasPermission('send_notifications'),
                'manage_notifications_permission' => $user->hasPermission('manage_notifications')
            ]);
            
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to send notifications.');
        }
        
        Log::info("Permission granted for sendCustom");
        
        $events = Event::where('end_date', '>=', now())
            ->orderBy('start_date')
            ->get();
        
        // Get all active users
        $users = User::orderBy('name')->get();
        
        return view('notifications.send-custom', compact('events', 'users'));
    }

    /**
     * Store and send custom notification
     */
    public function sendCustomStore(Request $request)
    {
        $user = Auth::user();
        
        Log::info("sendCustomStore called", [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'request_data' => $request->all()
        ]);
        
        // FIXED: Allow access for users with notification permissions OR admin
        if (!$user->hasPermission('send_notifications') && 
            !$user->hasPermission('manage_notifications') &&
            !$user->isAdmin()) {
            
            Log::warning("Permission denied for sendCustomStore", [
                'user_id' => $user->id
            ]);
            
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to send notifications.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => 'required|in:low,normal,high,urgent',
            'recipient_type' => 'required|in:all,specific,event_participants,waitlisted',
            'recipient_ids' => 'nullable|array',
            'recipient_ids.*' => 'exists:users,id',
            'event_id' => [
                'nullable',
                Rule::requiredIf(function () use ($request) {
                    return in_array($request->recipient_type, ['event_participants', 'waitlisted']);
                }),
                'exists:events,id'
            ],
        ]);
        
        Log::info("Validation passed", ['validated_data' => $validated]);
        
        DB::beginTransaction();
        
        try {
            // Determine recipients based on type
            $recipientIds = $this->determineRecipients($validated);
            
            Log::info("Determined recipients", [
                'count' => count($recipientIds),
                'recipient_ids' => $recipientIds
            ]);
            
            if (empty($recipientIds)) {
                Log::warning("No recipients found");
                return redirect()->back()
                    ->with('error', 'No recipients found for the selected criteria.')
                    ->withInput();
            }
            
            // Create the notification
            $notification = Notification::create([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'type' => 'custom',
                'priority' => $validated['priority'],
                'recipient_type' => $validated['recipient_type'],
                'recipient_ids' => json_encode($recipientIds),
                'event_id' => in_array($validated['recipient_type'], ['event_participants', 'waitlisted']) 
                    ? $validated['event_id'] 
                    : null,
                'sender_id' => $user->id,
                'sent_at' => now(),
            ]);
            
            // Create user notification records for each recipient
            $userNotifications = [];
            $now = now();
            
            foreach ($recipientIds as $userId) {
                $userNotifications[] = [
                    'user_id' => $userId,
                    'notification_id' => $notification->id,
                    'read_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            
            if (!empty($userNotifications)) {
                UserNotification::insert($userNotifications);
            }
            
            DB::commit();
            
            Log::info('Notification sent successfully', [
                'notification_id' => $notification->id,
                'sender_id' => $user->id,
                'recipient_count' => count($recipientIds),
                'recipient_type' => $validated['recipient_type']
            ]);
            
            return redirect()->route('notifications.index')
                ->with('success', "Notification sent successfully to " . count($recipientIds) . " recipients!");
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to send notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to send notification: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Determine recipients based on notification type
     */
    private function determineRecipients($data)
    {
        Log::info("Determining recipients", ['recipient_type' => $data['recipient_type']]);
        
        switch ($data['recipient_type']) {
            case 'all':
                // Get all users
                $users = User::pluck('id')->toArray();
                Log::info("All users selected", ['count' => count($users)]);
                return $users;
                
            case 'specific':
                $recipients = $data['recipient_ids'] ?? [];
                Log::info("Specific users selected", ['count' => count($recipients), 'ids' => $recipients]);
                return $recipients;
                
            case 'event_participants':
                if (empty($data['event_id'])) {
                    Log::warning("Event ID is empty for event_participants");
                    return [];
                }
                
                $event = Event::find($data['event_id']);
                Log::info("Looking for event", ['event_id' => $data['event_id'], 'found' => !is_null($event)]);
                
                if ($event && method_exists($event, 'registrations')) {
                    $participants = $event->registrations()
                        ->whereIn('status', ['confirmed', 'attended'])
                        ->pluck('user_id')
                        ->toArray();
                    Log::info("Event participants found", ['count' => count($participants)]);
                    return $participants;
                }
                Log::warning("Event not found or no registrations method");
                return [];
                
            case 'waitlisted':
                if (empty($data['event_id'])) {
                    Log::warning("Event ID is empty for waitlisted");
                    return [];
                }
                
                $event = Event::find($data['event_id']);
                Log::info("Looking for event for waitlist", ['event_id' => $data['event_id']]);
                
                if ($event && method_exists($event, 'waitlistRegistrations')) {
                    $waitlisted = $event->waitlistRegistrations()
                        ->where('status', 'waiting')
                        ->pluck('user_id')
                        ->toArray();
                    Log::info("Waitlisted users found", ['count' => count($waitlisted)]);
                    return $waitlisted;
                }
                Log::warning("Event not found or no waitlistRegistrations method");
                return [];
                
            default:
                Log::warning("Unknown recipient type", ['type' => $data['recipient_type']]);
                return [];
        }
    }

    /**
     * Get notification statistics
     */
    public function statistics(Request $request)
    {
        $user = Auth::user();
        
        // FIXED: Allow access for users with stats permission OR admin
        if (!$user->hasPermission('view_notification_stats') && 
            !$user->hasPermission('manage_notifications') &&
            !$user->isAdmin()) {
            
            Log::warning("Permission denied for statistics", [
                'user_id' => $user->id,
                'view_notification_stats' => $user->hasPermission('view_notification_stats'),
                'manage_notifications' => $user->hasPermission('manage_notifications')
            ]);
            
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to view notification statistics.');
        }
        
        Log::info("Permission granted for statistics");
        
        // Get date range
        $startDate = $request->input('start_date') 
            ? \Carbon\Carbon::parse($request->input('start_date'))->startOfDay()
            : now()->subDays(30);
            
        $endDate = $request->input('end_date')
            ? \Carbon\Carbon::parse($request->input('end_date'))->endOfDay()
            : now();
        
        // Calculate all statistics
        $totalSent = Notification::whereNotNull('sent_at')->count();
        $filteredSent = Notification::whereNotNull('sent_at')
            ->whereBetween('sent_at', [$startDate, $endDate])
            ->count();
        
        // Calculate high priority notifications
        $highPriority = Notification::whereNotNull('sent_at')
            ->whereIn('priority', ['high', 'urgent'])
            ->count();
        
        $filteredHighPriority = Notification::whereNotNull('sent_at')
            ->whereIn('priority', ['high', 'urgent'])
            ->whereBetween('sent_at', [$startDate, $endDate])
            ->count();
        
        // Calculate scheduled notifications
        $scheduledCount = Notification::whereNotNull('scheduled_at')
            ->where('sent_at', null)
            ->count();
        
        // Calculate event-related notifications
        $eventNotifications = Notification::whereNotNull('sent_at')
            ->whereNotNull('event_id')
            ->count();
        
        $filteredEventNotifications = Notification::whereNotNull('sent_at')
            ->whereNotNull('event_id')
            ->whereBetween('sent_at', [$startDate, $endDate])
            ->count();
        
        // Calculate monthly sent (current month)
        $monthlySent = Notification::whereNotNull('sent_at')
            ->whereBetween('sent_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
        
        // Build complete statistics array
        $statistics = [
            'total_sent' => $totalSent,
            'filtered_sent' => $filteredSent,
            'unique_recipients' => $this->getUniqueRecipientsCount($startDate, $endDate),
            'high_priority' => $highPriority,
            'filtered_high_priority' => $filteredHighPriority,
            'scheduled_count' => $scheduledCount,
            'today_sent' => Notification::whereNotNull('sent_at')
                ->whereDate('sent_at', today())
                ->count(),
            'weekly_sent' => Notification::whereNotNull('sent_at')
                ->whereBetween('sent_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'monthly_sent' => $monthlySent,
            'event_notifications' => $eventNotifications,
            'filtered_event_notifications' => $filteredEventNotifications,
            'custom_notifications' => Notification::where('type', 'custom')
                ->whereNotNull('sent_at')
                ->whereBetween('sent_at', [$startDate, $endDate])
                ->count(),
        ];
        
        return view('notifications.statistics', compact('statistics', 'startDate', 'endDate'));
    }

    /**
     * Get count of unique recipients in a date range
     */
    private function getUniqueRecipientsCount($startDate, $endDate)
    {
        $notifications = Notification::whereNotNull('sent_at')
            ->whereBetween('sent_at', [$startDate, $endDate])
            ->whereNotNull('recipient_ids')
            ->pluck('recipient_ids');
        
        $uniqueUsers = [];
        
        foreach ($notifications as $recipientJson) {
            $recipients = json_decode($recipientJson, true);
            if (is_array($recipients)) {
                $uniqueUsers = array_merge($uniqueUsers, $recipients);
            }
        }
        
        return count(array_unique($uniqueUsers));
    }
    
    /**
     * Display sent notifications
     */
    public function sent()
    {
        $user = Auth::user();
        
        // FIXED: Allow access for users with notification permissions OR admin
        if (!$user->hasPermission('send_notifications') && 
            !$user->hasPermission('manage_notifications') && 
            !$user->hasPermission('view_notification_stats') &&
            !$user->isAdmin()) {
            
            Log::warning('ACCESS DENIED to sent notifications', [
                'user_id' => $user->id,
                'user_name' => $user->name
            ]);
            
            return redirect()->route('notifications.index')
                ->with('error', 'You do not have permission to view sent notifications.');
        }
        
        Log::info('ACCESS GRANTED to sent notifications');
        
        // Get paginated notifications
        $notifications = Notification::with(['sender', 'event'])
            ->whereNotNull('sent_at')
            ->orderBy('sent_at', 'desc')
            ->paginate(15);
        
        // Calculate statistics
        $totalSent = Notification::whereNotNull('sent_at')->count();
        $todaySent = Notification::whereNotNull('sent_at')
            ->whereDate('sent_at', today())
            ->count();
        
        // Get current page notifications count
        $currentPageCount = $notifications->count();
        
        return view('notifications.sent', compact('notifications', 'totalSent', 'todaySent', 'currentPageCount'));
    }
}