<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard Admin: List Semua User
    public function index()
    {
        // Ambil semua user kecuali dirinya sendiri (Admin)
        $users = User::where('role', '!=', 'admin')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('dashboard.admin', compact('users'));
    }

    // Form Tambah User Baru
    public function create()
    {
        // Ambil list dosen untuk pilihan 'dosen pembimbing' saat buat mahasiswa
        $dosenList = User::where('role', 'dosen')->get();
        return view('admin.create_user', compact('dosenList'));
    }

    // Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'nomor_induk' => 'required|unique:users',
            'role' => 'required|in:dosen,mahasiswa',
            // Jika mahasiswa, wajib pilih dosen pembimbing
            'dosen_id' => 'required_if:role,mahasiswa|exists:users,id',
        ]);

        // 1. Buat Akun User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_induk' => $request->nomor_induk,
            'role' => $request->role,
            'password' => Hash::make('password'), // Default password
        ]);

        // 2. Buat Profil Kosongan (Sesuai Role)
        if ($request->role == 'mahasiswa') {
            \App\Models\Student::create([
                'user_id' => $user->id,
                'dosen_id' => $request->dosen_id
            ]);
        } elseif ($request->role == 'dosen') {
            \App\Models\Lecturer::create([
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan.');
    }

    // Hapus User
    public function destroy($id)
    {
        User::destroy($id);
        return back()->with('success', 'User berhasil dihapus.');
    }
}