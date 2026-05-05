<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->first();
        if (!$pedagang) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai pedagang.');
        }

        $menus = Menu::where('pedagang_id', $pedagang->id)->latest()->get();
        return view('menu.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'tipe_harga' => 'required|in:pas,custom',
            'harga_minimal' => 'required|numeric|min:0',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pedagang = Pedagang::where('user_id', Auth::id())->first();

        $path = null;
        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('menus', $nama_file, 'public');
        }

        Menu::create([
            'pedagang_id' => $pedagang->id,
            'nama_produk' => $request->nama_produk,
            'tipe_harga' => $request->tipe_harga,
            'harga_minimal' => $request->harga_minimal,
            'stok_status' => true,
            'foto_produk' => $path,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function update(Request $request, Menu $menu)
    {
        $pedagang = Pedagang::where('user_id', Auth::id())->first();
        
        // Proteksi akses
        if ($menu->pedagang_id !== $pedagang->id) {
            return redirect()->route('menu.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'tipe_harga' => 'required|in:pas,custom',
            'harga_minimal' => 'required|numeric|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $menu->foto_produk;
        if ($request->hasFile('foto_produk')) {
            if ($menu->foto_produk) {
                Storage::disk('public')->delete($menu->foto_produk);
            }
            $file = $request->file('foto_produk');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('menus', $nama_file, 'public');
        }

        $menu->update([
            'nama_produk' => $request->nama_produk,
            'tipe_harga' => $request->tipe_harga,
            'harga_minimal' => $request->harga_minimal,
            'foto_produk' => $path,
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->foto_produk) {
            Storage::disk('public')->delete($menu->foto_produk);
        }
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus.');
    }

    public function getActiveMenus()
    {
        $center_lat = -7.3274;
        $center_lng = 108.2207;
        $radius = 15;

        $menus = Menu::with(['pedagang:id,nama_toko'])
            ->join('pedagangs', 'menus.pedagang_id', '=', 'pedagangs.id')
            ->where('pedagangs.is_active', true)
            ->where('pedagangs.verified_user', true)
            ->whereNotNull('pedagangs.latitude')
            ->whereNotNull('pedagangs.longitude')
            ->select('menus.id', 'menus.pedagang_id', 'menus.nama_produk', 'menus.harga_minimal', 'menus.foto_produk')
            ->selectRaw(
                "(6371 * acos(cos(radians(?)) * cos(radians(pedagangs.latitude)) * cos(radians(pedagangs.longitude) - radians(?)) + sin(radians(?)) * sin(radians(pedagangs.latitude)))) AS distance",
                [$center_lat, $center_lng, $center_lat]
            )
            ->having('distance', '<', $radius)
            ->get();

        return response()->json($menus);
    }
}