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
        // 1. Tabel Kategori
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Makanan atau Minuman
        $table->string('slug');
        $table->timestamps();
    });

    // 2. Tambah kolom ke Menu (Relasi Kategori)
    Schema::table('menus', function (Blueprint $table) {
        $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
