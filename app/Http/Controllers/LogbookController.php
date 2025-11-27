<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Attendance; // <--- Import Model Attendance
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    // Menampilkan daftar logbook milik user login
    public function index()
    {
        $userId = Auth::id();
        $today = now()->format('Y-m-d');

        // 1. Cek apakah hari ini SUDAH absen masuk?
        $todayAttendance = Attendance::where('user_id', $userId)
                                     ->where('date', $today)
                                     ->first();

        $logbooks = Logbook::where('user_id', $userId)
                        ->orderBy('date', 'desc')
                        ->get();

        // Kirim variabel $todayAttendance ke view
        return view('logbooks.index', compact('logbooks', 'todayAttendance'));
    }

    // Menyimpan logbook baru
    public function store(Request $request)
    {
        $userId = Auth::id();
        $today = now()->format('Y-m-d');

        // 1. KEAMANAN BACKEND: Cek lagi apakah sudah absen
        $hasAttendance = Attendance::where('user_id', $userId)
                                   ->where('date', $today)
                                   ->exists();
        if (! $hasAttendance) {
            return back()->with('error', 'Anda harus absen masuk sebelum menulis logbook.');
        }

        // 2. Validasi input    
        $request->validate([
            'activity' => 'required|string|min:10',
            'date'     => 'required|date',
        ]);

        // Cek apakah sudah nulis logbook di tanggal yang sama? (Opsional, biar rapi)
        // Cek duplikasi logbook
        $exists = Logbook::where('user_id', $userId)
                    ->where('date', $request->date)
                    ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah mengisi logbook untuk tanggal tersebut.');
        }

        Logbook::create([
            'user_id'  => Auth::id(),
            'date'     => $request->date,
            'activity' => $request->activity,
        ]);

        return back()->with('success', 'Logbook berhasil disimpan!');
    }
}