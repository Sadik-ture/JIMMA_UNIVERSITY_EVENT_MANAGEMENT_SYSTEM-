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
            
            // Event Management
            ['name' => 'Manage Events', 'slug' => 'manage_events', 'description' => 'Can manage all events'],
            ['name' => 'View Events', 'slug' => 'view_events', 'description' => 'Can view events'],
            ['name' => 'Create Events', 'slug' => 'create_events', 'description' => 'Can create events'],
            ['name' => 'Edit Events', 'slug' => 'edit_events', 'description' => 'Can edit events'],
            ['name' => 'Delete Events', 'slug' => 'delete_events', 'description' => 'Can delete events'],
            
            // Speaker Management
            ['name' => 'Manage Speakers', 'slug' => 'manage_speakers', 'description' => 'Can manage all speakers'],
            ['name' => 'View Speakers', 'slug' => 'view_speakers', 'description' => 'Can view speakers'],
            ['name' => 'Create Speaker', 'slug' => 'create_speaker', 'description' => 'Can create speakers'],
            ['name' => 'Edit Speaker', 'slug' => 'edit_speaker', 'description' => 'Can edit speakers'],
            ['name' => 'Delete Speaker', 'slug' => 'delete_speaker', 'description' => 'Can delete speakers'],
            
            // Event Request Management
            ['name' => 'Manage Event Requests', 'slug' => 'manage_event_requests', 'description' => 'Can manage event requests'],
            ['name' => 'View Event Requests', 'slug' => 'view_event_requests', 'description' => 'Can view event requests'],
            ['name' => 'Create Event Request', 'slug' => 'create_event_request', 'description' => 'Can create event requests'],
            ['name' => 'Edit Event Request', 'slug' => 'edit_event_request', 'description' => 'Can edit event requests'],
            ['name' => 'Delete Event Request', 'slug' => 'delete_event_request', 'description' => 'Can delete event requests'],
            ['name' => 'Approve Event Requests', 'slug' => 'approve_event_requests', 'description' => 'Can approve event requests'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'slug' => $permission['slug']
            ], $permission);
        }

        // Assign all permissions to Super Admin
        $superAdmin = Role::where('slug', 'super-admin')->first();
        if ($superAdmin) {
            $allPermissions = Permission::all();
            $superAdmin->permissions()->sync($allPermissions->pluck('id'));
        }

        // Assign basic permissions to Admin
        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $adminPermissions = Permission::whereIn('slug', [
                'view_users', 'create_users', 'edit_users', 'delete_users',
                'view_roles', 'create_roles', 'edit_roles',
                'view_permissions', 'view_dashboard',
                'manage_events', 'view_events', 'create_events', 'edit_events', 'delete_events',
                'manage_speakers', 'view_speakers', 'create_speaker', 'edit_speaker', 'delete_speaker',
                'manage_event_requests', 'view_event_requests', 'create_event_request', 'edit_event_request', 'delete_event_request', 'approve_event_requests'
            ])->get();
            $admin->permissions()->sync($adminPermissions->pluck('id'));
        }

        // Assign basic permissions to Event Manager
        $eventManager = Role::where('slug', 'event-manager')->first();
        if ($eventManager) {
            $eventManagerPermissions = Permission::whereIn('slug', [
                'view_dashboard',
                'manage_events', 'view_events', 'create_events', 'edit_events',
                'manage_speakers', 'view_speakers', 'create_speaker', 'edit_speaker',
                'manage_event_requests', 'view_event_requests', 'create_event_request', 'edit_event_request', 'approve_event_requests'
            ])->get();
            $eventManager->permissions()->sync($eventManagerPermissions->pluck('id'));
        }

        // Assign basic permissions to Faculty
        $faculty = Role::where('slug', 'faculty')->first();
        if ($faculty) {
            $facultyPermissions = Permission::whereIn('slug', [
                'view_dashboard', 'view_events',
                'create_event_request', 'view_event_requests', 'edit_event_request'
            ])->get();
            $faculty->permissions()->sync($facultyPermissions->pluck('id'));
        }

        // Assign basic permissions to Student
        $student = Role::where('slug', 'student')->first();
        if ($student) {
            $studentPermissions = Permission::whereIn('slug', [
                'view_dashboard', 'view_events',
                'create_event_request', 'view_event_requests'
            ])->get();
            $student->permissions()->sync($studentPermissions->pluck('id'));
        }
    }
}