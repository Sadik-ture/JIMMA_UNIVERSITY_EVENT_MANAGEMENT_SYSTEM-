<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear tables in the right order (child tables first)
        $tables = [
            'user_notifications',
            'notifications',
            'event_registrations',
            'event_requests',
            'speakers',
            'events',
            'role_permission',  // Pivot table first
            'permissions',
            'users',
            'roles'
        ];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Now run seeders
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            EventSeeder::class,
            SpeakerSeeder::class,
        ]);
    }
}