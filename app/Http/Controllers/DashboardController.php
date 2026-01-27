<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'active_sessions' => 0, // You can implement session tracking if needed
        ];

        $recentUsers = User::with('role')->latest()->take(5)->get();
        $userRoleDistribution = Role::withCount('users')->get();

        return view('dashboard.index', compact('stats', 'recentUsers', 'userRoleDistribution'));
    }
}