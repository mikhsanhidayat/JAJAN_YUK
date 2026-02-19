<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminVerifikasiPedagangController;
use App\Http\Controllers\PedagangRegisController;
use App\Models\Menu;

// 1. Route untuk halaman utama (Guest/Belum Login)
Route::get('/', function () {
    // Hanya tampilkan menu dari pedagang yang sudah aktif/diverifikasi
    $menus = Menu::with(['pedagang', 'category'])->whereHas('pedagang', function($q) {
        $q->where('is_active', true);
    })->get();
    
    return view('dashboard', ['menus' => $menus]);
});

// 2. Route untuk Dashboard (Setelah Login)
Route::get('/dashboard', function () {
    $menus = Menu::with(['pedagang', 'category'])->whereHas('pedagang', function($q) {
        $q->where('is_active', true);
    })->get();

    return view('dashboard', compact('menus'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Grouping Route yang perlu Login
Route::middleware('auth')->group(function () {
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengelolaan Menu (Role Pedagang)
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');

    // Pendaftaran Pedagang & Geofencing Tasikmalaya
    Route::get('/daftar-pedagang', [PedagangRegisController::class, 'showRegistrationForm'])->name('pedagang.register');
    Route::post('/daftar-pedagang', [PedagangRegisController::class, 'store'])->name('pedagang.store');
    Route::get('/menunggu-verifikasi', function () {
        return view('pedagang.waiting');
    })->name('pedagang.waiting');

    // ===== Admin Verifikasi Pedagang =====
    // Middleware keamanan sudah ditangani di dalam Controller AdminVerifikasiPedagangController (Laravel 11 Style)
    Route::prefix('admin/verifikasi-pedagang')->name('admin.verifikasi.')->group(function () {
        Route::get('/', [AdminVerifikasiPedagangController::class, 'index'])->name('index');
        Route::get('/{pedagang}', [AdminVerifikasiPedagangController::class, 'show'])->name('show');
        Route::post('/{pedagang}/approve', [AdminVerifikasiPedagangController::class, 'approve'])->name('approve');
        Route::post('/{pedagang}/reject', [AdminVerifikasiPedagangController::class, 'reject'])->name('reject');
        Route::post('/{pedagang}/deactivate', [AdminVerifikasiPedagangController::class, 'deactivate'])->name('deactivate');
        Route::post('/{pedagang}/reactivate', [AdminVerifikasiPedagangController::class, 'reactivate'])->name('reactivate');
    });
});

require __DIR__.'/auth.php';