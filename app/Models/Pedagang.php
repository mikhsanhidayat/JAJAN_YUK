<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    protected $fillable = [
      'user_id', 'nama_toko', 'jenis_jajanan', 'is_active', 
    'latitude', 'longitude', 'foto_gerobak', 
    'payment_status', 'admin_status', 'bukti_pembayaran' // Tambahan
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
