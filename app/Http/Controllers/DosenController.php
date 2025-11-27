<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    // Halaman Utama Dosen: Menampilkan daftar mahasiswa bimbingan
    public function index()
    {
        $idDosen = Auth::id();

        // LOGIC BENAR: Menggunakan whereHas untuk mengecek relasi di tabel students
        $students = User::where('role', 'mahasiswa')
                        ->whereHas('student', function($query) use ($idDosen) {
                            $query->where('dosen_id', $idDosen);
                        })
                        ->with('student') // Eager load data profil
                        ->get();

        return view('dashboard.dosen', compact('students'));
    }

    // Halaman Detail: Melihat Logbook milik satu mahasiswa
    public function showStudentLogbooks($id)
    {
        // Load user beserta data profil student-nya
        $student = User::with('student')->findOrFail($id);

        // Validasi: Cek 'dosen_id' yang ada di dalam tabel profil 'student'
        // Gunakan optional() untuk jaga-jaga jika data profil belum diisi
        if (optional($student->student)->dosen_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke mahasiswa ini.');
        }

        $logbooks = Logbook::where('user_id', $id)
                        ->orderBy('date', 'desc')
                        ->get();

        return view('dosen.logbooks', compact('student', 'logbooks'));
    }

    // Aksi: Memberikan Feedback
    public function giveFeedback(Request $request, $logbookId)
    {
        $request->validate(['feedback' => 'required|string']);

        $logbook = Logbook::with('user.student')->findOrFail($logbookId);

        // Validasi kepemilikan: Cek via relasi user -> student -> dosen_id
        if (optional($logbook->user->student)->dosen_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menilai mahasiswa ini.');
        }

        $logbook->update([
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Feedback berhasil dikirim.');
    }
}