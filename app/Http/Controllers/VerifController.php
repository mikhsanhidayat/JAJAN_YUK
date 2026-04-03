<?php

namespace App\Http\Controllers;

use App\Models\Verif; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifController extends Controller
{
    public function index()
    {
        // Tampilkan halaman verifikasi
        return view('page.form_verification.index');
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
}