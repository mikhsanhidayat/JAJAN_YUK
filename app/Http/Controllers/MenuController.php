<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pedagang;
use App\Models\User;
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
        // Ambil data pedagang yang terikat dengan user login
        $pedagang = Pedagang::where('user_id', Auth::id())->first();
        $user = User::find(Auth::id());
        // Jika user bukan pedagang atau belum punya profil pedagang
        if (!$pedagang) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai pedagang.');
        }

        $menus = Menu::where('pedagang_id', $pedagang->id)->latest()->get();

        return view('menu.index', compact('menus', 'user'));
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
}