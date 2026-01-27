<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'View Users', 'slug' => 'view_users', 'description' => 'Can view users list'],
            ['name' => 'Create Users', 'slug' => 'create_users', 'description' => 'Can create new users'],
            ['name' => 'Edit Users', 'slug' => 'edit_users', 'description' => 'Can edit existing users'],
            ['name' => 'Delete Users', 'slug' => 'delete_users', 'description' => 'Can delete users'],
            
            // Role Management
            ['name' => 'View Roles', 'slug' => 'view_roles', 'description' => 'Can view roles list'],
            ['name' => 'Create Roles', 'slug' => 'create_roles', 'description' => 'Can create new roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit_roles', 'description' => 'Can edit existing roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete_roles', 'description' => 'Can delete roles'],
            
            // Permission Management
            ['name' => 'View Permissions', 'slug' => 'view_permissions', 'description' => 'Can view permissions list'],
            ['name' => 'Create Permissions', 'slug' => 'create_permissions', 'description' => 'Can create new permissions'],
            ['name' => 'Edit Permissions', 'slug' => 'edit_permissions', 'description' => 'Can edit existing permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete_permissions', 'description' => 'Can delete permissions'],
            
            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'view_dashboard', 'description' => 'Can view dashboard'],
            
            // Events (for future use)
            ['name' => 'Manage Events', 'slug' => 'manage_events', 'description' => 'Can manage all events'],
            ['name' => 'View Events', 'slug' => 'view_events', 'description' => 'Can view events'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign all permissions to Super Admin
        $superAdmin = Role::where('slug', 'super-admin')->first();
        $allPermissions = Permission::all();
        $superAdmin->permissions()->sync($allPermissions->pluck('id'));

        // Assign basic permissions to Admin
        $admin = Role::where('slug', 'admin')->first();
        $adminPermissions = Permission::whereIn('slug', [
            'view_users', 'create_users', 'edit_users', 'delete_users',
            'view_roles', 'create_roles', 'edit_roles',
            'view_permissions', 'view_dashboard'
        ])->get();
        $admin->permissions()->sync($adminPermissions->pluck('id'));

        // Assign basic permissions to Event Manager
        $eventManager = Role::where('slug', 'event-manager')->first();
        $eventManagerPermissions = Permission::whereIn('slug', [
            'view_dashboard', 'manage_events', 'view_events'
        ])->get();
        $eventManager->permissions()->sync($eventManagerPermissions->pluck('id'));

        // Assign basic permissions to Faculty
        $faculty = Role::where('slug', 'faculty')->first();
        $facultyPermissions = Permission::whereIn('slug', [
            'view_dashboard', 'view_events'
        ])->get();
        $faculty->permissions()->sync($facultyPermissions->pluck('id'));

        // Assign basic permissions to Student
        $student = Role::where('slug', 'student')->first();
        $studentPermissions = Permission::whereIn('slug', [
            'view_dashboard', 'view_events'
        ])->get();
        $student->permissions()->sync($studentPermissions->pluck('id'));
    }
}