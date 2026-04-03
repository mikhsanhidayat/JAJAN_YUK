<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verif extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bukti_transfer',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);   
    }                 
}
