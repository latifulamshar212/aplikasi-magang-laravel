<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // 0. Buat Akun ADMIN
        User::create([
            'name' => 'Super Admin',
            'nomor_induk' => 'admin', // Username login admin
            'email' => 'admin@kampus.ac.id',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);
        // ============================
        // 1. Buat Akun DOSEN (Pak Budi)
        // ============================
        $pakBudi = User::create([
            'name' => 'Budi Santoso, M.Kom',
            'nomor_induk' => '198501012010121001', // NIP
            'email' => 'dosen@kampus.ac.id',
            'role' => 'dosen',
            'password' => Hash::make('password'),
        ]);

        // Isi detail profil dosen
        Lecturer::create([
            'user_id' => $pakBudi->id,
            'kode_dosen' => 'KDS01',
            'no_hp' => '081234567890',
        ]);

        // ============================
        // 2. Buat Akun MAHASISWA (Ahmad)
        // ============================
        $ahmad = User::create([
            'name' => 'Ahmad Junaidi',
            'nomor_induk' => '2023903430020', // NIM
            'email' => 'mahasiswa@kampus.ac.id',
            'role' => 'mahasiswa',
            'password' => Hash::make('password'),
        ]);

        // Isi detail profil mahasiswa & Sambungkan ke Pak Budi
        Student::create([
            'user_id' => $ahmad->id,
            'dosen_id' => $pakBudi->id, // <--- KUNCI RELASINYA DISINI
            'kelas' => 'TI-A',
            'jurusan' => 'Teknik Informatika',
        ]);
    }
}