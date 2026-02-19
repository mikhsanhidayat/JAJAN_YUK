<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterPedagangController extends Controller
{
    public function create()
    {
        if (Auth::check() && Auth::user()->pedagang) {
            return redirect()->route('dashboard');
        }
        return view('auth.register-pedagang'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nama_toko' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'bukti_pembayaran' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $tasikLat = -7.3274;
        $tasikLon = 108.2207;
        $distance = $this->calculateDistance($request->latitude, $request->longitude, $tasikLat, $tasikLon);

        if ($distance > 20) {
            return back()->withInput()->with('error', 'Maaf, lokasi jualan Anda harus berada di wilayah Tasikmalaya (Radius 20KM).');
        }

        try {
            DB::beginTransaction();

            // 1. Simpan Akun User
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pedagang', 
            ]);

            // 2. Upload Bukti Bayar
            $path = $request->file('bukti_pembayaran')->store('payments', 'public');

            // 3. Simpan Profil Pedagang Otomatis
            Pedagang::create([
                'user_id' => $user->id,
                'nama_toko' => $request->nama_toko,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'bukti_pembayaran' => $path,
                'payment_status' => 'pending',
                'admin_status' => 'pending',
                'is_active' => false,
            ]);

            DB::commit();

            Auth::login($user);
            return redirect()->route('register-pedagang.waiting')
                             ->with('success', 'Pendaftaran berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Sistem error: ' . $e->getMessage());
        }
    }

    public function waiting()
    {
        $pedagang = Auth::user()->pedagang;

        if (!$pedagang) {
            return redirect()->route('register-pedagang');
        }

        return view('auth.register-pedagang-waiting', compact('pedagang'));
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}