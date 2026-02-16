<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Ensure user has permission to view dashboard
        $this->middleware('can:view_dashboard');
    }

    public function index()
    {
        // Get basic stats
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'active_sessions' => $this->getActiveSessions(),
            'unique_visitors' => rand(20, 60), // Simulated for demo
        ];

        // Get recent users with their roles
        $recentUsers = User::with('role')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get user role distribution
        $userRoleDistribution = Role::withCount('users')
            ->having('users_count', '>', 0)
            ->orderBy('users_count', 'desc')
            ->get();

        // Get currently active users (with last activity in last 5 minutes)
        $activeUsers = User::where('updated_at', '>=', now()->subMinutes(5))
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'stats', 
            'recentUsers', 
            'userRoleDistribution',
            'activeUsers'
        ));
    }

    public function getDashboardStats()
    {
        // Only return if user has permission
        if (!Auth::user()->hasPermission('view_dashboard')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'recent_users' => User::with('role')->latest()->take(5)->get(),
        ]);
    }

    /**
     * Get active sessions count
     * This is a simplified version - you may want to implement proper session tracking
     */
    private function getActiveSessions()
    {
        // Get users active in last 15 minutes
        return User::where('updated_at', '>=', now()->subMinutes(15))->count();
    }
}