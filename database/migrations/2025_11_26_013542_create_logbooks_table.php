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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            // Relasi ke User (Mahasiswa yang nulis)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();
            
            $table->date('date');           // Tanggal kegiatan
            $table->text('activity');       // Isi kegiatan
            $table->text('feedback')->nullable(); // Balasan Dosen (Boleh kosong awal2)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
