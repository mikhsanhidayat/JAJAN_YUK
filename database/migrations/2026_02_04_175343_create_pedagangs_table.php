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
       Schema::create('pedagangs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('nama_toko');
        $table->string('jenis_jajanan')->nullable();
        $table->boolean('is_active')->default(false); // Toggle On/Off
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->timestamp('last_heartbeat')->nullable(); // Anti gerobak hantu
        $table->string('foto_gerobak')->nullable();
        $table->boolean('verified_user')->default(false); // Pastikan satu user hanya bisa jadi satu pedagang
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedagangs');
    }
};
