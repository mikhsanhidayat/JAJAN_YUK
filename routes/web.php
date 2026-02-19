<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Models\Menu; // Tambahkan ini agar model Menu bisa dibaca

// Route untuk halaman utama (Guest/Belum Login)
// Contoh di web.php
Route::get('/', function () {
    // Ambil data menu yang pedagangnya aktif
    $menus = Menu::with('pedagang')->whereHas('pedagang', function($q) {
        $q->where('is_active', true);
    })->get();

    return view('dashboard', compact('menus'));
})->name('home');   


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
});

require __DIR__.'/auth.php';