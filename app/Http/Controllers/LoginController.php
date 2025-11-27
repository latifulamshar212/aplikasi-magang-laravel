<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Logika Otentikasi (NIM/NIP atau Email)
    public function authenticate(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nomor_induk';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        // --- CUKUP SATU KALI PENGECEKAN DI SINI ---
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $role = Auth::user()->role;

            // 1. Cek Admin
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } 
            // 2. Cek Dosen
            elseif ($role === 'dosen') {
                return redirect()->intended('/dosen/dashboard');
            }

            // 3. Default: Mahasiswa
            return redirect()->intended('/dashboard');
        }
        // ------------------------------------------

        return back()->withErrors([
            'login' => 'NIM/NIP, Email, atau Password salah.',
        ])->onlyInput('login');
    }
}