<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\PedagangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerifController;
use App\Models\Menu; // Tambahkan ini agar model Menu bisa dibaca
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama (Guest/Belum Login)
// Contoh di web.php
Route::get('/', function () {
    $menus = \App\Models\Menu::with('pedagang')->get();
    return view('dashboard', ['menus' => $menus]);
});

// Route untuk Dashboard (Setelah Login)
Route::get('/dashboard', function () {
    // Ambil data menu yang pedagangnya aktif
    $menus = Menu::with('pedagang')->whereHas('pedagang', function($q) {
        $q->where('is_active', true);
    })->get();

    return view('dashboard', compact('menus'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Grouping Route yang perlu Login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sebaiknya taruh route menu di dalam group auth agar aman
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

    // Route untuk halaman form pedagang
    Route::get('/pedagang', [PedagangController::class, 'index'])->name('pedagang.index');
    Route::post('/pedagang', [PedagangController::class, 'store'])->name('pedagang.store');

    // Route untuk halaman verifikasi
    Route::get('/verifikasi', [VerifController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi', [VerifController::class, 'store'])->name('verifikasi.store');

});

require __DIR__.'/auth.php';