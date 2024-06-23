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
            $table->foreignId('release_id')->constrained('releases')->onDelete('cascade'); // Adding foreign key constraint with cascading delete
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
            $table->string('song_writer')->nullable();
            $table->string('track_producer')->nullable();
            $table->string('composer_name')->nullable();
            $table->string('track_lyrics_name')->nullable();
            $table->string('track_label_name')->nullable();
            $table->string('isrc')->nullable();
            $table->string('track_performers')->nullable();
            $table->string('cname')->nullable();
            $table->string('pname')->nullable();
            $table->string('ownership_for_sound_rec')->nullable();
            $table->string('original_release_date')->nullable();
            $table->string('sales_date')->nullable();
            $table->string('country_of_rec')->nullable();
            $table->string('nationality')->nullable();
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
