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
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->enum('format', ['single', 'ep', 'album'])->nullable();
            $table->string('release_name')->nullable();
            $table->string('release_version')->nullable();
            $table->string('release_code')->nullable();
            $table->string('upc')->nullable();    
            $table->string('meta_language')->nullable();   
            $table->string('primary_artist')->nullable();
            $table->string('featuring_artist')->nullable();
            $table->string('remixer')->nullable();
            $table->string('producer')->nullable();
            $table->string('genre')->nullable();
            $table->string('sub_genre')->nullable();
            $table->string('copy_rights')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->text('note')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('releases');
    }
};
