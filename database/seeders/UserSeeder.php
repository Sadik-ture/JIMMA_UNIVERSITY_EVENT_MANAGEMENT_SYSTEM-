<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin
        $superAdminRole = Role::where('slug', 'super-admin')->first();
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@ju.edu.et',
            'password' => Hash::make('password123'),
            'role_id' => $superAdminRole->id,
        ]);

        // Create Admin
        $adminRole = Role::where('slug', 'admin')->first();
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@ju.edu.et',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
        ]);

        // Create Event Manager
        $eventManagerRole = Role::where('slug', 'event-manager')->first();
        User::create([
            'name' => 'Event Manager',
            'email' => 'events@ju.edu.et',
            'password' => Hash::make('password123'),
            'role_id' => $eventManagerRole->id,
        ]);

        // Create Faculty
        $facultyRole = Role::where('slug', 'faculty')->first();
        User::create([
            'name' => 'Dr. Alemayehu',
            'email' => 'alemayehu@ju.edu.et',
            'password' => Hash::make('password123'),
            'role_id' => $facultyRole->id,
        ]);

        // Create Student
        $studentRole = Role::where('slug', 'student')->first();
        User::create([
            'name' => 'Student User',
            'email' => 'student@ju.edu.et',
            'password' => Hash::make('password123'),
            'role_id' => $studentRole->id,
        ]);
    }
}