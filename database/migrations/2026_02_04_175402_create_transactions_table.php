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
        Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pembeli_id')->constrained('users');
        $table->foreignId('pedagang_id')->constrained('pedagangs');
        $table->integer('total_harga');
        $table->enum('status_pembayaran', ['pending', 'sukses', 'gagal'])->default('pending');
        $table->string('qr_token')->unique(); // Untuk scan validasi
        $table->boolean('is_scanned')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
