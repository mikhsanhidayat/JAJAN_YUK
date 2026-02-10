<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedagangRegisController extends Controller
{
    public function showRegistrationForm()
    {
        // Jika sudah punya profil pedagang, arahkan ke dashboard
        if (Auth::user()->pedagang) {
            return redirect()->route('dashboard');
        }
        return view('pedagang.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            'bukti_pembayaran' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 1. CEK RADIUS (Geofencing Tasikmalaya)
        $tasikLat = -7.3274;
        $tasikLon = 108.2207;
        $distance = $this->calculateDistance($request->latitude, $request->longitude, $tasikLat, $tasikLon);

        if ($distance > 20) { // Radius 20KM dari pusat Tasik
            return back()->with('error', 'Maaf, lokasi jualan Anda harus berada di wilayah Tasikmalaya.');
        }

        // 2. PROSES UPLOAD BUKTI BAYAR
        $path = $request->file('bukti_pembayaran')->store('payments', 'public');

        // 3. SIMPAN DATA PEDAGANG
        Pedagang::create([
            'user_id' => Auth::id(),
            'nama_toko' => $request->nama_toko,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'bukti_pembayaran' => $path,
            'payment_status' => 'pending', // Menunggu verifikasi admin
            'admin_status' => 'pending',   // Menunggu verifikasi admin
            'is_active' => false,          // Belum boleh muncul di peta
        ]);

        return redirect()->route('pedagang.waiting');
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