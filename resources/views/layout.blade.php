<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Magang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

    <nav class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl">Sistem Magang</h1>
            <div class="flex items-center gap-4">
                {{-- Cek apakah user sudah login --}}
                @auth
                    <span>Halo, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</button>
                    </form>
                @endauth

                {{-- Jika belum login (tamu) --}}
                @guest
                    <span class="text-sm italic">Silakan Login</span>
                @endguest
            </div>
            <div class="flex items-center gap-6">
                @auth
                    @if (auth()->user()->role == 'mahasiswa')
                        <a href="{{ route('dashboard') }}"
                            class="text-white hover:text-blue-200 {{ request()->routeIs('dashboard') ? 'font-bold underline' : '' }}">Absensi</a>
                        <a href="{{ route('logbooks.index') }}"
                            class="text-white hover:text-blue-200 {{ request()->routeIs('logbooks.*') ? 'font-bold underline' : '' }}">Logbook</a>
                    @endif

                    <span class="text-sm bg-blue-700 px-3 py-1 rounded">
                        {{ Auth::user()->name }}
                        <small class="block text-xs opacity-75 capitalize">{{ Auth::user()->role }}</small>
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</button>
                    </form>
                @endauth
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
