<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar menu milik pedagang yang sedang login
     */
    public function index()
    {


        $pedagang = Pedagang::where('user_id', Auth::id())->first();

     
        
        $menus = Menu::where('pedagang_id', $pedagang->id)->get();
        return view('menu.index', compact('menus'));
       
    }

    /**
     * Menampilkan form tambah menu
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Menyimpan menu baru ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'tipe_harga' => 'required|in:pas,custom',
            'harga_minimal' => 'required|numeric|min:0',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // 2. Ambil ID Pedagang
        $pedagang = Pedagang::where('user_id', Auth::id())->first();

        // 3. Proses Upload Foto
        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('menus', $nama_file, 'public');
        }

        // 4. Simpan ke Database
        Menu::create([
            'pedagang_id' => $pedagang->id,
            'nama_produk' => $request->nama_produk,
            'tipe_harga' => $request->tipe_harga,
            'harga_minimal' => $request->harga_minimal,
            'stok_status' => true, // Default tersedia
            'foto_produk' => $path ?? null,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan ke katalog!');
    }

    /**
     * Menghapus menu (Opsional)
     */
    public function destroy(Menu $menu)
    {
        // Hapus file foto dari storage
        if ($menu->foto_produk) {
            Storage::disk('public')->delete($menu->foto_produk);
        }

        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    public function getNearbyMenu(Request $request)
{
    // Koordinat User (didapat dari Browser/GPS)
    $userLat = $request->lat; 
    $userLon = $request->lon;

    // 1. CEK GEOFENCING (Misal Radius 20KM dari Tasikmalaya)
    $tasikLat = -7.3274;
    $tasikLon = 108.2207;
    $distanceToTasik = $this->calculateDistance($userLat, $userLon, $tasikLat, $tasikLon);

    if ($distanceToTasik > 20) {
        return response()->json(['message' => 'Maaf, JajanYuk hanya tersedia di Tasikmalaya'], 403);
    }

    // 2. FILTER PEDAGANG (Sudah Bayar & Disetujui Admin)
    $menus = Menu::whereHas('pedagang', function($q) {
        $q->where('payment_status', 'paid')
          ->where('admin_status', 'approved')
          ->where('is_active', true);
    })->with(['pedagang', 'category'])->get();

    return view('dashboard', compact('menus'));
}

// Fungsi Haversine Formula untuk hitung jarak
private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earthRadius * $c;
}
}