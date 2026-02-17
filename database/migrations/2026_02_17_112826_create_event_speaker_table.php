<?php
// database/migrations/2024_01_01_000002_create_event_speaker_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_speaker', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('speaker_id')->constrained()->onDelete('cascade');
            $table->string('session_title')->nullable();
            $table->dateTime('session_time')->nullable();
            $table->integer('session_duration')->nullable(); // in minutes
            $table->text('session_description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_keynote')->default(false);
            $table->boolean('is_moderator')->default(false);
            $table->boolean('is_panelist')->default(false);
            $table->json('custom_data')->nullable();
            $table->timestamps();
            
            // Ensure a speaker is not assigned twice to the same event
            $table->unique(['event_id', 'speaker_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_speaker');
    }
};