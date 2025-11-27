<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Magang</title>
    {{-- Gunakan CDN Tailwind agar styling Link Profile langsung jalan --}}
    @vite('resources/css/app.css', 'resources/js/app.js')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>

<body class="bg-gray-100 font-sans">

    <nav class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">

            {{-- JUDUL / LOGO --}}
            <h1 class="font-bold text-xl">Sistem Magang</h1>

            {{-- MENU KANAN --}}
            <div class="flex items-center gap-6">

                {{-- JIKA SUDAH LOGIN --}}
                @auth

                    {{-- Menu Navigasi Mahasiswa --}}
                    @if (auth()->user()->role == 'mahasiswa')
                        <div class="hidden md:flex gap-4">
                            <a href="{{ route('dashboard') }}"
                                class="text-white hover:text-blue-200 {{ request()->routeIs('dashboard') ? 'font-bold underline' : '' }}">Absensi</a>
                            <a href="{{ route('logbooks.index') }}"
                                class="text-white hover:text-blue-200 {{ request()->routeIs('logbooks.*') ? 'font-bold underline' : '' }}">Logbook</a>
                        </div>
                    @endif

                    {{-- Menu Navigasi Dosen --}}
                    @if (auth()->user()->role == 'dosen')
                        <a href="{{ route('dosen.dashboard') }}" class="font-bold underline hover:text-blue-200">Dashboard
                            Dosen</a>
                    @endif

                    {{-- === BAGIAN INI YANG DIUBAH (NAMA USER JADI LINK) === --}}
                    <a href="{{ route('profile.edit') }}"
                        class="group flex items-center gap-3 bg-blue-700 hover:bg-blue-800 px-3 py-1 rounded transition border border-transparent hover:border-blue-400">
                        <div class="text-right leading-tight">
                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                            <small class="block text-xs opacity-75 capitalize">{{ Auth::user()->role }}</small>
                        </div>
                        {{-- Ikon Pensil Kecil (Indikator Edit) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70 group-hover:opacity-100"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </a>
                    {{-- ================================================= --}}

                    {{-- Tombol Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded text-sm transition">Logout</button>
                    </form>
                @endauth

                {{-- JIKA BELUM LOGIN (TAMU) --}}
                @guest
                    <a href="{{ route('login') }}" class="text-sm italic hover:underline">Silakan Login</a>
                @endguest

            </div>
        </div>
    </nav>

    <main class="container mx-auto p-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>

</html>
