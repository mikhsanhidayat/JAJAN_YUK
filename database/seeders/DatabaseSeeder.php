<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pedagang;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- PROSES MEMBERSIHKAN DATA LAMA ---
        Schema::disableForeignKeyConstraints();
        DB::table('menus')->truncate();
        DB::table('pedagangs')->truncate();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        // --- 1. BUAT USER PEDAGANG (BANDUNG) ---
        $userPedagang = User::create([
            'nama' => 'Mang Oleh Bandung',
            'email' => 'oleh@example.com',
            'password' => Hash::make('password'),
            'role' => 'pedagang',
        ]);

      
        $pedagang = Pedagang::create([
            'user_id' => $userPedagang->id,
            'nama_toko' => 'Odading Mang Oleh Bandung',
            'jenis_jajanan' => 'Kue Tradisional',
            'is_active' => true,
            'latitude' => -7.327400,  // Titik Tasikmalaya (Pusat Kota)
'longitude' => 108.220700, // Titik Tasikmalaya (Pusat Kota)
            'foto_gerobak' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=400',
            'verified_user' => true, // Tandai sebagai pedagang yang sudah diverifikasi
        ]);

        // --- 3. MENU UNTUK PEDAGANG BANDUNG ---
        Menu::create([
            'pedagang_id' => $pedagang->id, 
            'nama_produk' => 'Odading Spesial Bandung',
            'tipe_harga' => 'pas',
            'harga_minimal' => 5000,
            'stok_status' => true,
            'foto_produk' => 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400' 
        ]);

        Menu::create([
            'pedagang_id' => $pedagang->id,
            'nama_produk' => 'Cilok Goang Bandung',
            'tipe_harga' => 'custom',
            'harga_minimal' => 2000,
            'stok_status' => true,
            'foto_produk' => 'https://images.unsplash.com/photo-1626074353765-517a681e40be?q=80&w=400'
        ]);

        Menu::create([
            'pedagang_id' => $pedagang->id,
            'nama_produk' => 'Es Jeruk Peras',
            'tipe_harga' => 'pas',
            'harga_minimal' => 7000,
            'stok_status' => true,
            'foto_produk' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?q=80&w=400'
        ]);

        // --- 4. SEED UNTUK ROLE ADMIN ---
        User::create([
            'nama' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            
        ]);
    }
}