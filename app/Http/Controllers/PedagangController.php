<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedagangController extends Controller
{
    public function index()
    {
        if (!Auth::check() || strtolower(Auth::user()->role) !== 'pedagang') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak: hanya pedagang yang dapat melihat halaman ini.');
        }

        $pedagangs = Pedagang::all();
        return view('page.form_pedagang.index', compact('pedagangs'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'jenis_jajanan' => 'required|string',
            'foto_gerobak' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $pedagang = new Pedagang();
            $pedagang->user_id = Auth::id();
            $pedagang->nama_toko = $request->nama_toko;
            $pedagang->jenis_jajanan = $request->jenis_jajanan;

            if ($request->hasFile('foto_gerobak')) {
                $file = $request->file('foto_gerobak');
                $nama_file = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto_gerobak', $nama_file, 'public');
                $pedagang->foto_gerobak = $path;
            }

            $pedagang->save();

            return redirect()->back()->with('success', 'Profil toko berhasil didaftarkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function updateLokasi(Request $request)
    {
        $pedagang = Pedagang::where('user_id', auth()->id())->first();

        if ($pedagang) {
            if (! $pedagang->verified_user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Akun Anda belum diverifikasi admin. GPS tidak dapat diaktifkan.'
                ], 403);
            }

            $pedagang->update([
                'is_active' => $request->is_active,
                'latitude'  => $request->is_active ? $request->latitude : null,
                'longitude' => $request->is_active ? $request->longitude : null,
                'last_heartbeat' => $request->is_active ? now() : $pedagang->last_heartbeat
            ]);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 404);
    }

    /**
     * Mengambil data pedagang aktif dengan filter radius Kota Tasikmalaya
     */
    public function getActivePedagang()
    {
        try {
            // Tentukan Titik Pusat Kota Tasikmalaya (Tugu Asmaul Husna/Pusat Kota)
            $center_lat = -7.3274; 
            $center_lng = 108.2207;
            
            // Tentukan radius maksimal dalam Kilometer (Misal: 15 KM untuk mencakup area kota)
            $radius = 15; 

            // Query dengan rumus Haversine untuk menghitung jarak di dalam database
            $pedagangAktif = Pedagang::where('is_active', true)
                ->where('verified_user', true)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->select('*')
                // 6371 adalah konstanta untuk radius bumi dalam Kilometer
                ->selectRaw(
                    "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
                    [$center_lat, $center_lng, $center_lat]
                )
                // Filter agar hanya mengambil yang masuk dalam radius
                ->having('distance', '<', $radius)
                // Urutkan dari yang terdekat
                ->orderBy('distance', 'asc')
                ->get();

            return response()->json($pedagangAktif);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data pedagang: ' . $e->getMessage()], 500);
        }
    }

    // App\Http\Controllers\PedagangController.php

public function getPedagangAktif()
{   
    $pedagang = Pedagang::where('is_active', true)
                        ->where('verified_user', true)
                        ->get();

    return response()->json($pedagang);
}

// App\Http\Controllers\MenuController.php

public function getMenusAktif()
{
    // Mengambil menu dari pedagang yang sedang aktif saja
    $menus = Menu::with('pedagang')
                ->whereHas('pedagang', function($query) {
                    $query->where('is_active', true)
                          ->where('verified_user', true);
                })
                ->get();

    return response()->json($menus);
}
}