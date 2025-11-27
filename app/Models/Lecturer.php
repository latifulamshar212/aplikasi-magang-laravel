<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    // Agar kita bisa langsung isi semua kolom tanpa nulis fillable satu-satu
    protected $guarded = ['id']; 

    // Relasi balik ke akun User utama
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}