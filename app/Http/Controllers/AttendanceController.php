<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    // Tambahkan method ini di dalam class AttendanceController

    public function index()
    {
        $user = Auth::user();
        $today = now()->format('Y-m-d');

        // Ambil data absen hari ini (jika ada)
        $todayAttendance = \App\Models\Attendance::where('user_id', $user->id)
                            ->where('date', $today)
                            ->first();

        // Data history singkat (opsional, 5 hari terakhir)
        $history = \App\Models\Attendance::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();

        return view('dashboard.mahasiswa', compact('user', 'todayAttendance', 'history'));
    }
        // LOGIKA ABSEN MASUK (DIPERBAIKI)
        public function clockIn(Request $request)
        {
            $user = Auth::user();
            $now = Carbon::now('Asia/Jakarta'); 
            $today = $now->format('Y-m-d');
            $currentTime = $now->format('H:i:s');

            // 1. Cek apakah sudah absen hari ini?
            $cekAbsen = Attendance::where('user_id', $user->id)
                            ->where('date', $today)
                            ->first();

            if ($cekAbsen) {
                return back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
            }

            // 2. Tentukan Status & Validasi Jam
            $status = '';

            // --- PERBAIKAN DISINI ---
            
            // A. Cek Batas Bawah (Misal absen baru dibuka jam 06:00 pagi)
            if ($currentTime < '06:00:00') {
                return back()->with('error', 'Absen belum dibuka. Silakan absen mulai pukul 06:00.');
            }

            // B. Logika Tepat Waktu (06:00 - 07:30)
            if ($currentTime >= '06:00:00' && $currentTime <= '07:30:00') {
                $status = 'tepat_waktu';
            
            // C. Logika Terlambat (07:31 - 08:00)
            } elseif ($currentTime > '07:30:00' && $currentTime <= '08:00:00') {
                $status = 'terlambat';
            
            // D. Telat Parah / Tidak bisa absen (> 08:00)
            } else {
                return back()->with('error', 'Maaf, batas waktu absen (08:00) sudah lewat. Anda dianggap tidak hadir.');
            }

            // 3. Simpan Data
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'clock_in' => $currentTime,
                'status' => $status,
            ]);

            return back()->with('success', 'Absen masuk berhasil! Status: ' . $status);
        }

    // LOGIKA ABSEN PULANG
    public function clockOut()
    {
        $user = Auth::user();
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        // 1. Cek Aturan Jam Pulang (Minimal 16:00)
        if ($currentTime < '16:00:00') {
            return back()->with('error', 'Belum waktunya pulang. Tunggu hingga 16:00.');
        }

        // 2. Cari data absen hari ini
        $attendance = Attendance::where('user_id', $user->id)
                        ->where('date', $today)
                        ->first();

        if (!$attendance) {
            return back()->with('error', 'Anda belum absen masuk hari ini.');
        }

        if ($attendance->clock_out) {
            return back()->with('error', 'Anda sudah absen pulang sebelumnya.');
        }

        // 3. Update Jam Pulang
        $attendance->update([
            'clock_out' => $currentTime
        ]);

        return back()->with('success', 'Hati-hati di jalan! Absen pulang tercatat.');
    }
}