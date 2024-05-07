<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('music', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['single', 'ep', 'album'])->nullable();
            $table->string('title')->nullable();
            $table->string('artist')->nullable();
            $table->string('track_code')->unique()->nullable();
            $table->date('release_date')->nullable();
            $table->string('genre')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->json('track_paths')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->timestamps(); 
        });

      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('music');
    }
};
