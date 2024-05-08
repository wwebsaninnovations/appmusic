<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('release_id');
            $table->bigInteger('user_id');
            $table->string('track_path')->nullable();
            $table->string('track_name')->nullable();
            $table->string('track_duration')->nullable();
            $table->string('track_version')->nullable();
            $table->string('lyrics_language')->nullable();
            $table->enum('explicit_content', ['none', 'explicit', 'clean'])->nullable();
            $table->string('track_primary_artist')->nullable();
            $table->string('track_featuring_artist')->nullable();
            $table->string('track_remixer')->nullable();
            $table->string('track_writer')->nullable();
            $table->string('track_producer')->nullable();
            $table->string('composer')->nullable();
            $table->string('track_lyrics_name')->nullable();
            $table->string('track_label_name')->nullable();
            $table->string('isrc')->nullable();
            $table->string('track_performers')->nullable();
            $table->string('publisher_rights')->nullable();
            $table->string('ownership_for_soound_rec')->nullable();

    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
