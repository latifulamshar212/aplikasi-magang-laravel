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
            'login'    => 'required|string', // Input fleksibel
            'password' => 'required|string',
        ]);

        // Cek apakah input berupa Email atau Nomor Induk (NIM/NIP)
        // Kita memanfaatkan fungsi bawaan PHP untuk validasi email
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nomor_induk';

        // Persiapkan kredensial
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Cek Role User
            $user = Auth::user();

            if ($user->role === 'dosen') {
                // Jika Dosen, arahkan ke dashboard dosen (Nanti kita buat)
                return redirect()->intended('/dosen/dashboard');
            }

            // Jika Mahasiswa, arahkan ke dashboard mahasiswa (Absensi)
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login' => 'NIM/NIP, Email, atau Password salah.',
        ])->onlyInput('login');
    }
    
    // Logika Logout sudah ada di routes/web.php
}