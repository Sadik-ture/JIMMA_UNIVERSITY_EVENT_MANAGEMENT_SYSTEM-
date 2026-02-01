<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        // Only require auth for create, edit, update, destroy
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy', 'togglePublish', 'statistics']);
        
        // Add debugging
        Log::info('AnnouncementController initialized');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Announcement::with('creator');
        
        // For non-admin users or guests, only show published announcements
        if (!$user || (!$user->hasPermission('manage_announcements') && !$user->hasPermission('view_announcements'))) {
            $query = $query->where('is_published', true);
            
            // Filter by audience for logged-in users
            if ($user) {
                $query->where(function($q) use ($user) {
                    $q->where('audience', 'all')
                      ->orWhere('audience', $user->role->slug ?? 'guest')
                      ->orWhere(function($q2) use ($user) {
                          $q2->where('audience', 'specific')
                             ->whereJsonContains('target_ids', $user->id);
                      });
                });
            }
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Filter by audience
        if ($request->filled('audience')) {
            $query->where('audience', $request->audience);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }
        
        // Filter expired announcements
        if ($request->filled('expired')) {
            if ($request->expired === 'yes') {
                $query->whereNotNull('expires_at')->where('expires_at', '<', now());
            } elseif ($request->expired === 'no') {
                $query->where(function($q) {
                    $q->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
                });
            }
        }
        
        // Order by priority: urgent first, then by date
        $query->orderByRaw("CASE WHEN type = 'urgent' THEN 0 ELSE 1 END")
              ->orderBy('created_at', 'desc');
        
        $announcements = $query->paginate(12);
        
        // Get stats
        $stats = $this->getAnnouncementStats();
        
        return view('announcements.index', compact('announcements', 'stats'));
    }

    public function create()
    {
        Log::info('AnnouncementController@create called', [
            'user' => Auth::user() ? Auth::user()->id : 'guest',
            'url' => request()->fullUrl()
        ]);
        
        $users = User::where('is_active', true)
                     ->orWhereNull('is_active')
                     ->with('role')
                     ->orderBy('name')
                     ->get(['id', 'name', 'email', 'role_id']);
        
        return view('announcements.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:event,campus,general,urgent',
            'audience' => 'required|in:all,students,faculty,staff,specific',
            'target_ids' => 'nullable|array',
            'target_ids.*' => 'exists:users,id',
            'expires_at' => 'nullable|date|after:now',
            'publish_now' => 'boolean',
        ]);
        
        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'audience' => $request->audience,
            'target_ids' => $request->audience == 'specific' ? $request->target_ids : null,
            'created_by' => Auth::id(),
            'is_published' => $request->has('publish_now'),
            'published_at' => $request->has('publish_now') ? now() : null,
            'expires_at' => $request->expires_at,
        ]);
        
        return redirect()->route('announcements.show', $announcement->id)
            ->with('success', 'Announcement created successfully!');
    }

    public function show($id)
    {
        Log::info('AnnouncementController@show called', ['id' => $id]);
        
        // If the ID is "create" or "statistics", show 404
        if ($id === 'create' || $id === 'statistics') {
            abort(404, 'Announcement not found');
        }
        
        $announcement = Announcement::with('creator')->findOrFail($id);
        
        $user = Auth::user();
        
        // Check if user can view the announcement
        if (!$announcement->is_published) {
            if (!$user || (!$user->hasPermission('manage_announcements') && !$user->hasPermission('view_announcements'))) {
                abort(404);
            }
        }
        
        // Check audience restrictions for non-admin users
        if ($user && !$user->hasPermission('manage_announcements')) {
            $canView = false;
            
            if ($announcement->audience === 'all') {
                $canView = true;
            } elseif ($announcement->audience === ($user->role->slug ?? 'guest')) {
                $canView = true;
            } elseif ($announcement->audience === 'specific' && $announcement->target_ids) {
                $canView = in_array($user->id, $announcement->target_ids);
            }
            
            if (!$canView) {
                abort(403, 'You are not authorized to view this announcement.');
            }
        }
        
        // Record view for authenticated users
        if ($user) {
            DB::table('announcement_views')->updateOrInsert(
                ['announcement_id' => $announcement->id, 'user_id' => $user->id],
                ['viewed_at' => now()]
            );
            $announcement->increment('views');
        }
        
        // Get related announcements
        $relatedAnnouncements = Announcement::where('id', '!=', $announcement->id)
            ->where('is_published', true)
            ->where(function($q) use ($announcement) {
                $q->where('type', $announcement->type)
                  ->orWhere('audience', $announcement->audience);
            })
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        // Get users for display if needed
        $users = collect();
        if ($announcement->audience === 'specific' && $announcement->target_ids) {
            $users = User::whereIn('id', $announcement->target_ids)->get();
        }
        
        return view('announcements.show', compact('announcement', 'relatedAnnouncements', 'users'));
    }

    public function edit($id)
    {
        Log::info('AnnouncementController@edit called', ['id' => $id]);
        
        $announcement = Announcement::findOrFail($id);
        
        $users = User::where('is_active', true)
                     ->orWhereNull('is_active')
                     ->with('role')
                     ->orderBy('name')
                     ->get(['id', 'name', 'email', 'role_id']);
        
        return view('announcements.edit', compact('announcement', 'users'));
    }

    public function update(Request $request, $id)
    {
        Log::info('AnnouncementController@update called', ['id' => $id]);
        
        $announcement = Announcement::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:event,campus,general,urgent',
            'audience' => 'required|in:all,students,faculty,staff,specific',
            'target_ids' => 'nullable|array',
            'target_ids.*' => 'exists:users,id',
            'expires_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);
        
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'audience' => $request->audience,
            'target_ids' => $request->audience == 'specific' ? $request->target_ids : null,
            'expires_at' => $request->expires_at,
            'is_published' => $request->is_published ?? $announcement->is_published,
        ];
        
        // Set published_at if publishing for the first time
        if ($request->is_published && !$announcement->published_at) {
            $data['published_at'] = now();
        }
        
        $announcement->update($data);
        
        return redirect()->route('announcements.show', $announcement->id)
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy($id)
    {
        Log::info('AnnouncementController@destroy called', ['id' => $id]);
        
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        
        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }

    public function togglePublish($id)
    {
        Log::info('AnnouncementController@togglePublish called', ['id' => $id]);
        
        $announcement = Announcement::findOrFail($id);
        
        $announcement->update([
            'is_published' => !$announcement->is_published,
            'published_at' => $announcement->is_published ? null : now(),
        ]);
        
        $message = $announcement->is_published ? 'published' : 'unpublished';
        
        return back()->with('success', "Announcement {$message} successfully!");
    }

    public function statistics()
    {
        Log::info('AnnouncementController@statistics called', [
            'user' => Auth::user() ? Auth::user()->id : 'guest'
        ]);
        
        // Get basic stats
        $totalAnnouncements = Announcement::count();
        $publishedAnnouncements = Announcement::where('is_published', true)->count();
        
        $activeAnnouncements = Announcement::where('is_published', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })->count();
        
        $totalViews = Announcement::sum('views');
        
        // Get type distribution
        $byType = Announcement::select('type', DB::raw('count(*) as count'), DB::raw('sum(views) as total_views'))
            ->groupBy('type')
            ->orderBy('count', 'desc')
            ->get();
        
        // Get audience distribution
        $byAudience = Announcement::select('audience', DB::raw('count(*) as count'))
            ->groupBy('audience')
            ->orderBy('count', 'desc')
            ->get();
        
        // Get most viewed
        $mostViewed = Announcement::where('is_published', true)
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get();
        
        // Get recent announcements
        $recentAnnouncements = Announcement::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get monthly trend
        $monthlyTrend = Announcement::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw("COUNT(*) as count"),
                DB::raw("SUM(views) as total_views")
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        return view('announcements.statistics', compact(
            'totalAnnouncements',
            'publishedAnnouncements',
            'activeAnnouncements',
            'totalViews',
            'byType',
            'byAudience',
            'mostViewed',
            'recentAnnouncements',
            'monthlyTrend'
        ));
    }

    private function getAnnouncementStats()
    {
        $totalAnnouncements = Announcement::count();
        $publishedAnnouncements = Announcement::where('is_published', true)->count();
        
        // Count active announcements (not expired)
        $activeAnnouncements = Announcement::where('is_published', true)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })->count();
        
        $totalViews = Announcement::sum('views');
        
        return [
            'totalAnnouncements' => $totalAnnouncements,
            'publishedAnnouncements' => $publishedAnnouncements,
            'activeAnnouncements' => $activeAnnouncements,
            'totalViews' => $totalViews,
        ];
    }
}