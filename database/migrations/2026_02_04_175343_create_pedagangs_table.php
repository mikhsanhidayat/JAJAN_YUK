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
        $table->decimal('latitude', 10, 8)->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->string('foto_gerobak')->nullable();
        
        // Payment & Verification
        $table->enum('payment_status', ['pending', 'paid'])->default('pending');
        $table->enum('admin_status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->string('bukti_pembayaran')->nullable(); // Path ke bukti transfer
        
        // Status Aktif (Otomatis berdasarkan payment_status dan admin_status)
        $table->boolean('is_active')->default(false); // Toggle On/Off oleh system
        $table->timestamp('last_heartbeat')->nullable(); // Anti gerobak hantu
        
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
