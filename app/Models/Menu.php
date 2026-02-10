<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'pedagang_id', 'category_id', 'nama_produk', // Tambah category_id
    'tipe_harga', 'harga_minimal', 'stok_status', 'foto_produk',
    ];

    public function pedagang()
    {
        return $this->belongsTo(Pedagang::class);
    }

    public function category() {
    return $this->belongsTo(Category::class);
}
}
