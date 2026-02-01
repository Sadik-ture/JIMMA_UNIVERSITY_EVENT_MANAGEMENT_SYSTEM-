<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Rename featured_image to image
            $table->renameColumn('featured_image', 'image');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Rename image back to featured_image
            $table->renameColumn('image', 'featured_image');
        });
    }
};