<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    // Tambahkan di dalam class Order
protected $fillable = [
    'user_id', 'pedagang_id', 'external_id', 'total_harga', 
    'payment_status', 'checkout_link', 'catatan', 
    'waktu_pengambilan', 'kode_pengambilan', 'order_status'
];

// Relasi ke User (Pembeli)
public function user()
{
    return $this->belongsTo(User::class);
}

// Relasi ke Pedagang
public function pedagang()
{
    return $this->belongsTo(Pedagang::class);
}

// Relasi ke rincian item (Order Details)
public function details()
{
    return $this->hasMany(OrderDetail::class);
}
}
