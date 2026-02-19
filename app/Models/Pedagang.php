<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    protected $fillable = [
    'user_id',
    'nama_toko',
    'latitude',
    'longitude',
    'bukti_pembayaran',
    'payment_status',
    'admin_status',
    'is_active'
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
