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
        Schema::create('stok_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pembeli_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('pedagang_id')->constrained('pedagangs')->onDelete('cascade');
        $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
        $table->integer('nominal_request')->nullable(); // Input harga jika custom
        $table->text('catatan_pembeli')->nullable();
        $table->enum('status_respon', ['pending', 'tersedia', 'habis'])->default('pending');
        $table->text('catatan_pedagang')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_requests');
    }
};
