<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    // Tambahkan di dalam class OrderDetail
protected $fillable = [
    'order_id', 'menu_id', 'nama_produk_history', 
    'jumlah', 'harga_satuan', 'subtotal'
];

// Relasi balik ke Order induk
public function order()
{
    return $this->belongsTo(Order::class);
}

// Relasi ke Menu
public function menu()
{
    return $this->belongsTo(Menu::class);
}
}
