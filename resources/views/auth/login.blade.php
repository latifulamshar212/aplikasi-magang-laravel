<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css', 'resources/js/app.js')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white h-screen flex overflow-hidden">

    <div class="hidden lg:flex w-1/2 bg-indigo-600 items-center justify-center relative">
        <div class="absolute inset-0 bg-linear-to-br from-indigo-600 to-purple-700 opacity-90"></div>
        <div class="relative z-10 text-white p-12 max-w-lg">
            <h1 class="text-5xl font-extrabold mb-6 tracking-tight">Mulai Karir Digitalmu.</h1>
            <p class="text-indigo-100 text-lg leading-relaxed">Sistem manajemen magang terintegrasi untuk mempermudah
                presensi, laporan harian, dan bimbingan dosen.</p>
        </div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-tr-full"></div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="max-w-md w-full">
            <div class="text-center mb-10">
                <div
                    class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-indigo-100 text-indigo-600 font-bold text-xl mb-4">
                    M</div>
                <h2 class="text-3xl font-bold text-slate-900">Selamat Datang Kembali</h2>
                <p class="text-slate-500 mt-2">Masukan kredensial Anda untuk mengakses akun.</p>
            </div>

            <form method="POST" action="/login" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email / NIM / NIP</label>
                    <input type="text" name="login" required autofocus
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:outline-none transition"
                        placeholder="Contoh: 202155201001">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:outline-none transition"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-indigo-500/30 transition transform hover:-translate-y-0.5">
                    Masuk ke Dashboard
                </button>

                @if ($errors->any())
                    <div class="p-3 bg-red-50 text-red-600 text-sm rounded-lg text-center border border-red-100">
                        {{ $errors->first() }}
                    </div>
                @endif
            </form>

            <p class="mt-8 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} Sistem Magang. All rights reserved.
            </p>
        </div>
    </div>

</body>

</html>
