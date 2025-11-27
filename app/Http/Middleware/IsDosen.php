<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsDosen
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN role-nya dosen
        if (!Auth::check() || Auth::user()->role !== 'dosen') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Dosen.');
        }

        return $next($request);
    }
}