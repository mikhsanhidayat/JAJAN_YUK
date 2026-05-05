<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
    'nama',      // Ubah dari 'name'
    'email',
    'password',
    'role',      // Tambahkan ini
    'foto_profil',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Pedagang
     * User bisa punya satu record pedagang
     */
    public function pedagang()
    {
        return $this->hasOne(Pedagang::class);
    }

    /**
     * Cek apakah user sudah terdaftar sebagai pedagang
     * @return bool
     */
    public function sudahMenjadiPedagang()
    {
        return $this->pedagang()->exists();
    }

    /**
     * Cek apakah pedagang sudah aktif (is_active = 1)
     * @return bool
     */
    public function pedagangAktif()
    {
        return $this->pedagang && $this->pedagang->is_active == 1;
    }

    /**
     * Cek apakah pedagang sudah diverifikasi oleh admin
     * @return bool
     */
    public function pedagangTerverifikasi()
    {
        return $this->pedagang && $this->pedagang->verified_user == 1;
    }

    /**
     * Relasi ke tabel verifikasi yang menandakan user sudah mengajukan verifikasi
     */
    public function verif()
    {
        return $this->hasOne(Verif::class);
    }

    /**
     * Cek apakah user sudah mengajukan verifikasi ke admin
     * @return bool
     */
    public function hasPendingVerification()
    {
        return $this->verif()->exists();
    }

    public function hasRole($role) {
        return $this->role === $role; // Sesuaikan dengan nama kolom role di tabel user Anda
    }
}
