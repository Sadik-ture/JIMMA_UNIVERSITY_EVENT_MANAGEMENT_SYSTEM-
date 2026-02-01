<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Add read tracking
            $table->timestamp('read_at')->nullable()->after('sent_at');
            
            // Or add a boolean if you prefer
            // $table->boolean('is_read')->default(false)->after('sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('read_at');
            // $table->dropColumn('is_read');
        });
    }
};