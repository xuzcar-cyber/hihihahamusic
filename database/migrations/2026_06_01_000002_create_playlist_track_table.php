<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('playlist_track', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained()->onDelete('cascade');
            $table->foreignId('track_id')->constrained()->onDelete('cascade');
            $table->integer('position')->default(0);
            $table->timestamps();
            
            $table->unique(['playlist_id', 'track_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('playlist_track');
    }
};
