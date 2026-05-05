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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // ID Pembeli
            $table->foreignId('pedagang_id')->constrained('pedagangs'); // ID Pedagang

            // Keperluan Xendit & Keuangan
            $table->string('external_id')->unique(); // ID unik untuk invoice Xendit
            $table->integer('total_harga');
            $table->enum('payment_status', ['pending', 'paid', 'expired', 'failed'])->default('pending');
            $table->string('checkout_link')->nullable(); // URL Invoice dari Xendit

            // Keperluan Take Away
            $table->text('catatan')->nullable(); // Notes dari pembeli
            $table->time('waktu_pengambilan'); // Jam rencana ambil
            $table->string('kode_pengambilan', 6)->unique(); // Kode unik (misal: JYN001)

            // Status Alur Kerja
            $table->enum('order_status', ['menunggu_pembayaran', 'diproses', 'siap_diambil', 'selesai', 'dibatalkan'])->default('menunggu_pembayaran');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
