<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pedagang;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)

    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:pedagang,admin,pembeli',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto profil
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'foto_profil' => $request->hasFile('foto_profil') ? $request->file('foto_profil')->store('foto_profil', 'public') : null, // Simpan foto profil jika ada
        ]);

        // Setelah user berhasil dibuat, buat profil pedagang untuk user tersebut
        // Pedagang::create([
        //     'user_id' => $user->id,
        //     'nama_toko' => '', // Bisa diisi nanti di halaman profil
        //     'lokasi' => '', // Bisa diisi nanti di halaman profil
        //     'foto_toko' => '', // Bisa diisi nanti di halaman profil
        // ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/dashboard');


      
    }
}
