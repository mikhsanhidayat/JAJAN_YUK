<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pedagang;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Pedagang
//         $user = User::create([
//             'nama' => 'Mang Oleh',
//             'email' => 'oleh@example.com',
//             'password' => Hash::make('password'),
//             'role' => 'pedagang',
//         ]);

//         // 2. Profil Pedagang (Lokasi Tasikmalaya)
//         $pedagang = Pedagang::create([
//             'user_id' => $user->id, 
//             'nama_toko' => 'Odading Mang Oleh',
//             'jenis_jajanan' => 'Kue Tradisional',
//             'is_active' => true,
//            'latitude' => -7.327300,   // geser sedikit ke utara
// 'longitude' => 108.22300, // geser sedikit ke timur
//             'foto_gerobak' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=400' // Foto dummy
//         ]);

//         // 3. Menu dengan Foto Jajanan
//         Menu::create([
//             'pedagang_id' => $pedagang->id,
//             'nama_produk' => 'Odading Spesial',
//             'tipe_harga' => 'pas',
//             'harga_minimal' => 5000,
//             'stok_status' => true,
//             'foto_produk' => 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400' 
//         ]);

//         Menu::create([
//             'pedagang_id' => $pedagang->id,
//             'nama_produk' => 'Cilok Goang Pedas',
//             'tipe_harga' => 'custom',
//             'harga_minimal' => 2000,
//             'stok_status' => true,
//             'foto_produk' => 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400'
//         ]);

//         Menu::create([
//             'pedagang_id' => $pedagang->id,
//             'nama_produk' => 'Es Jeruk Peras',
//             'tipe_harga' => 'pas',
//             'harga_minimal' => 7000,
//             'stok_status' => true,
//             'foto_produk' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?q=80&w=400'
//         ]);
//         $user = User::create([
//             'nama' => 'Mang ana',
//             'email' => 'ana@example.com',
//             'password' => Hash::make('password'),
//             'role' => 'pedagang',
//         ]);

//         // 2. Profil Pedagang (Lokasi Tasikmalaya)
//         $pedagang = Pedagang::create([
//             'user_id' => $user->id, 
//             'nama_toko' => 'Odading Mang ana',
//             'jenis_jajanan' => 'Kue Tradisional',
//             'is_active' => true,
//            'latitude' => -7.327100,   // geser sedikit ke utara
// 'longitude' => 108.221000, // geser sedikit ke timur
//             'foto_gerobak' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=400' // Foto dummy
//         ]);

//         // 3. Menu dengan Foto Jajanan
//         Menu::create([
//             'pedagang_id' => $pedagang->id,
//             'nama_produk' => 'Odading Spesial',
//             'tipe_harga' => 'pas',
//             'harga_minimal' => 5000,
//             'stok_status' => true,
//             'foto_produk' => 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400' 
//         ]);

//         Menu::create([
//             'pedagang_id' => $pedagang->id,
//             'nama_produk' => 'Cilok Goang Pedas',
//             'tipe_harga' => 'custom',
//             'harga_minimal' => 2000,
//             'stok_status' => true,
//             'foto_produk' => 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400'
//         ]);

//         Menu::create([
//             'pedagang_id' => $pedagang->id,
//             'nama_produk' => 'Es Jeruk Peras',
//             'tipe_harga' => 'pas',
//             'harga_minimal' => 7000,
//             'stok_status' => true,
//             'foto_produk' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?q=80&w=400'
//         ]);

        $user = User::create([
            'nama' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'nama' => 'Pembeli',
            'email' => 'pembeli@example.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);

    }
}