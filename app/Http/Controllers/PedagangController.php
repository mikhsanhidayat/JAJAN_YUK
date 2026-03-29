<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PedagangController extends Controller
{
    public function index()
    {
        $pedagangs = Pedagang::all();
        // Sesuaikan path view dengan struktur folder Anda
        return view('page.form_pedagang.index', compact('pedagangs'));
    }

   public function store(Request $request)
{
    // 1. Pastikan pengguna sudah login sebelum memproses
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
        
        // Menggunakan Auth::id() lebih aman
        $pedagang->user_id = Auth::id(); 
        $pedagang->nama_toko = $request->nama_toko;
        $pedagang->jenis_jajanan = $request->jenis_jajanan;

        if ($request->hasFile('foto_gerobak')) {
            $file = $request->file('foto_gerobak');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            
            // Simpan ke folder sesuai struktur folder Anda
            $path = $file->storeAs('foto_gerobak', $nama_file, 'public');
            $pedagang->foto_gerobak = $path;
        }

        $pedagang->save();

        return redirect()->back()->with('success', 'Profil toko berhasil didaftarkan!');
    } catch (\Exception $e) {
        // Ini akan memberitahu jika ada masalah koneksi atau query database
        return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
}
}