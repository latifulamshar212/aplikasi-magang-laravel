<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = ['id'];

    // Relasi balik ke akun User diri sendiri
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Dosen Pembimbing (mengarah ke tabel users)
    // Ingat: di migration, foreign key-nya adalah 'dosen_id'
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}