<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pedagang;
use App\Services\GeofencingService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterPedagangController extends Controller
{
    /**
     * Tampilkan form registrasi pedagang - Step 1 (Data Akun)
     */
    public function create(): View
    {
        return view('auth.register-pedagang');
    }

    /**
     * Proses registrasi pedagang Step 1 - Simpan User
     * Redirect ke step 2 untuk lengkapi profil
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan user dengan role pedagang
        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pedagang',
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Redirect ke step 2: lengkapi profil
        return redirect()->route('register-pedagang.profile');
    }

    /**
     * Tampilkan form Step 2 - Lengkapi Profil & Lokasi
     */
    public function showProfile(): View
    {
        $user = Auth::user();
        $pedagang = $user->pedagang ?? null;

        return view('auth.register-pedagang-profile', compact('pedagang'));
    }

    /**
     * Proses Step 2 - Simpan Profil Pedagang dengan Geofencing & Upload Bukti Bayar
     */
    public function storeProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'jenis_jajanan' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'foto_gerobak' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'bukti_pembayaran' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // ===== VALIDASI GEOFENCING =====
        $geofence = GeofencingService::validateLocation(
            (float)$validated['latitude'],
            (float)$validated['longitude']
        );

        if (!$geofence['isValid']) {
            return back()
                ->withInput()
                ->withErrors(['location' => $geofence['message']]);
        }

        // ===== UPLOAD FILE =====
        $fotoGerobakPath = $request->file('foto_gerobak')->store('pedagang/gerobak', 'public');
        $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('pedagang/bukti', 'public');

        // ===== SIMPAN DATA PEDAGANG =====
        Pedagang::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_toko' => $validated['nama_toko'],
                'jenis_jajanan' => $validated['jenis_jajanan'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'foto_gerobak' => $fotoGerobakPath,
                'bukti_pembayaran' => $buktiPembayaranPath,
                'payment_status' => 'pending', // Belum dibayar
                'admin_status' => 'pending',   // Menunggu verifikasi admin
                'is_active' => false,          // Belum aktif
            ]
        );

        // Redirect ke halaman menunggu verifikasi
        return redirect()->route('register-pedagang.waiting');
    }

    /**
     * Tampilkan halaman "Menunggu Verifikasi"
     */
    public function waiting()
    {
        $user = Auth::user();
        $pedagang = $user->pedagang;

        if (!$pedagang) {
            return redirect()->route('register-pedagang.profile');
        }

        return view('auth.register-pedagang-waiting', compact('pedagang'));
    }
}
