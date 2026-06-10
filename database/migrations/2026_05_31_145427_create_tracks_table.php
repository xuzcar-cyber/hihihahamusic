<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tracks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->string('artist');
    $table->string('genre')->nullable();
    $table->string('file_path');
    $table->string('cover_path')->nullable();
    $table->unsignedInteger('likes_count')->default(0);
    $table->timestamps();
});
    }
    public function down() { Schema::dropIfExists('tracks'); }
};