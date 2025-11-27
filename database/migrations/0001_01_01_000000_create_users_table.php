<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // 'nomor_induk' akan diisi NIM (mhs) atau NIP (dosen)
            $table->string('nomor_induk')->unique();
            $table->enum('role', ['dosen', 'mahasiswa']);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (akun login)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();
            $table->string('kode_dosen')->nullable(); // Contoh data spesifik dosen
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // Relasi ke akun login sendiri
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();
            
            // Relasi ke Dosen Pembimbing (Hubungan ke tabel users milik dosen)
            // Kita ambil ID dari tabel 'users' yang role-nya dosen, bukan dari tabel 'lecturers'
            // agar relasi Eloquent lebih mudah.
            $table->foreignId('dosen_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('kelas')->nullable(); // Contoh data spesifik mhs
            $table->string('jurusan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('lecturers');
        Schema::dropIfExists('students');
    }
};
