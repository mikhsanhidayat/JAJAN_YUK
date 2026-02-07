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
       Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pedagang_id')->constrained('pedagangs')->onDelete('cascade');
        $table->string('nama_produk');
        $table->enum('tipe_harga', ['pas', 'custom'])->default('pas');
        $table->integer('harga_minimal'); // Harga tetap atau batas bawah
        $table->boolean('stok_status')->default(true);
        $table->string('foto_produk')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
