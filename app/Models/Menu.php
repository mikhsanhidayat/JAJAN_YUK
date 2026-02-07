<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'pedagang_id',
        'nama_produk',
        'tipe_harga',
        'harga_minimal',
        'stok_status',
        'foto_produk',
    ];

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class);
    }
}
