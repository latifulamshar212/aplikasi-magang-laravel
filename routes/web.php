<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController; // Import Controller Admin
use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\CheckRole; // Kita cukup pakai satu middleware sakti ini

// 1. HALAMAN DEPAN
Route::get('/', function () {
    return view('landing');
})->name('home');

// 2. TAMU
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); 
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// 3. USER UMUM (MAHASISWA & FITUR UMUM)
Route::middleware(['auth'])->group(function () {
    // Dashboard Mahasiswa (Default)
    Route::get('/dashboard', [AttendanceController::class, 'index'])->name('dashboard');

    // Fitur Absensi & Logbook (Mahasiswa)
    Route::post('/attendance/in', [AttendanceController::class, 'clockIn'])->name('attendance.in');
    Route::post('/attendance/out', [AttendanceController::class, 'clockOut'])->name('attendance.out');
    Route::get('/logbooks', [LogbookController::class, 'index'])->name('logbooks.index');
    Route::post('/logbooks', [LogbookController::class, 'store'])->name('logbooks.store');

    // Fitur Umum (Cetak & Profil)
    Route::get('/report/print', [ReportController::class, 'print'])->name('report.print');
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

// 4. GROUP ADMIN (Pakai CheckRole:admin)
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/user/create', [AdminController::class, 'create'])->name('admin.user.create');
    Route::post('/admin/user', [AdminController::class, 'store'])->name('admin.user.store');
    Route::delete('/admin/user/{id}', [AdminController::class, 'destroy'])->name('admin.user.delete');
});

// 5. GROUP DOSEN (Pakai CheckRole:dosen) -> Lebih rapi
Route::middleware(['auth', CheckRole::class . ':dosen'])->group(function () {
    Route::get('/dosen/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');
    Route::get('/dosen/student/{id}', [DosenController::class, 'showStudentLogbooks'])->name('dosen.student.show');
    Route::post('/dosen/feedback/{logbookId}', [DosenController::class, 'giveFeedback'])->name('dosen.feedback.store');
});