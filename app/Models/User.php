<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (Mass Assignment)
     */
    protected $fillable = [
        'name',
        'nomor_induk', // <--- PENTING: Tambahkan ini
        'email',
        'role',        // <--- PENTING: Tambahkan ini
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke Profile Mahasiswa
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // Relasi ke Profile Dosen
    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }
}