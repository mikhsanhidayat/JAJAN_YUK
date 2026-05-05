<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use App\Models\Verif; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifController extends Controller
{
   public function index()
{
    // Mengambil data verif beserta data user dan data pedagang terkait
    $verifikasi = \App\Models\Verif::with(['user.pedagang'])->latest()->get();

    return view('page.form_verification.index', compact('verifikasi'));
}
    public function create()
    {
        // Tampilkan form untuk mengunggah bukti transfer
        return view('page.form_verification.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $verif = new Verif();
        $verif->user_id = Auth::id();

        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('bukti_transfer'), $filename);
            $verif->bukti_transfer = 'bukti_transfer/' . $filename;
        }

        $verif->save();

        return redirect()->route('dashboard')->with('success', 'Bukti transfer berhasil diunggah!');
    }

    public function approve($id)
{
    // 1. Cari data verifikasi berdasarkan ID
    $verif = Verif::findOrFail($id);

    // 2. Cari data pedagang milik user tersebut
    $pedagang = Pedagang::where('user_id', $verif->user_id)->first();

    if ($pedagang) {
        // 3. Tandai pedagang sebagai terverifikasi oleh admin
        $pedagang->update([
            'verified_user' => true,
        ]);

        // 4. Hapus data verifikasi (karena sudah disetujui)
        $verif->delete();

        return redirect()->back()->with('success', 'Pedagang berhasil diverifikasi oleh admin.');
    }

    return redirect()->back()->with('error', 'Data pedagang tidak ditemukan.');
}
}