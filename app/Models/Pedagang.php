<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_toko',
        'jenis_jajanan',
        'is_active',
        'latitude',
        'longitude',
        'last_heartbeat',
        'foto_gerobak',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}