<?php
// database/seeders/DatabaseSeeder.php - UPDATED

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
            'event_speaker', // Pivot table first
            'event_registrations',
            'event_requests',
            'speakers',
            'events',
            'campuses',
            'buildings',
            'venues',
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
            CampusSeeder::class,
            BuildingSeeder::class,
            VenueSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            SpeakerSeeder::class,
            EventSeeder::class,
        ]);
    }
}