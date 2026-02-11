<?php
// database/migrations/2024_01_01_100000_fix_event_images.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // First check if featured_image column exists and rename it to image
            if (Schema::hasColumn('events', 'featured_image')) {
                $table->renameColumn('featured_image', 'image');
            }
            
            // Ensure image column exists with proper configuration
            if (!Schema::hasColumn('events', 'image')) {
                $table->string('image')->nullable()->after('contact_phone');
            }
            
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('events', 'short_description')) {
                $table->text('short_description')->nullable()->after('description');
            }
            
            if (!Schema::hasColumn('events', 'status')) {
                $table->string('status')->default('upcoming')->after('registration_link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'image') && !Schema::hasColumn('events', 'featured_image')) {
                $table->renameColumn('image', 'featured_image');
            }
            
            if (Schema::hasColumn('events', 'short_description')) {
                $table->dropColumn('short_description');
            }
            
            if (Schema::hasColumn('events', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};