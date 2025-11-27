<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsDosen;

// 1. HALAMAN DEPAN (LANDING PAGE) - Bisa diakses siapa saja
Route::get('/', function () {
    return view('landing');
})->name('home');

// 2. GROUP TAMU (Belum Login)
Route::middleware('guest')->group(function () {
    // Halaman Login (Sekarang di /login, bukan di / lagi)
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
    
    // Proses Login
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// 2. GROUP USER (Sudah Login: Mahasiswa & Dosen)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard (Nanti kita akan pilah tampilan Dosen vs Mahasiswa di Controllernya)
    Route::get('/dashboard', [AttendanceController::class, 'index'])->name('dashboard');

    // Fitur Absensi (Mahasiswa)
    Route::post('/attendance/in', [AttendanceController::class, 'clockIn'])->name('attendance.in');
    Route::post('/attendance/out', [AttendanceController::class, 'clockOut'])->name('attendance.out');

    // Fitur Logbook (Mahasiswa)
    Route::get('/logbooks', [LogbookController::class, 'index'])->name('logbooks.index');
    Route::post('/logbooks', [LogbookController::class, 'store'])->name('logbooks.store');

    // Route Cetak Laporan
    Route::get('/report/print', [ReportController::class, 'print'])->name('report.print');

    // Fitur Edit Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});


// === GROUP ROUTE KHUSUS DOSEN ===
Route::middleware(['auth', IsDosen::class])->group(function () {
    
    // Dashboard Dosen (List Mahasiswa)
    Route::get('/dosen/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');
    
    // Lihat Logbook Mahasiswa Tertentu
    Route::get('/dosen/student/{id}', [DosenController::class, 'showStudentLogbooks'])->name('dosen.student.show');
    
    // Kirim Feedback
    Route::post('/dosen/feedback/{logbookId}', [DosenController::class, 'giveFeedback'])->name('dosen.feedback.store');

});