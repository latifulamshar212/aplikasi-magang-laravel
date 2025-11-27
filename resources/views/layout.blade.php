<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Magang Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css', 'resources/js/app.js')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6 h-16 flex justify-between items-center">

            <a href="/" class="flex items-center gap-2">
                <div
                    class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                    M</div>
                <span class="font-bold text-xl tracking-tight text-slate-900">Magang<span
                        class="text-indigo-600">App</span></span>
            </a>

            <div class="flex items-center gap-6">
                @auth
                    @if (auth()->user()->role == 'mahasiswa')
                        <div class="hidden md:flex gap-1 bg-slate-100 p-1 rounded-lg">
                            <a href="{{ route('dashboard') }}"
                                class="px-4 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Absensi
                            </a>
                            <a href="{{ route('logbooks.index') }}"
                                class="px-4 py-1.5 rounded-md text-sm font-medium transition {{ request()->routeIs('logbooks.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Logbook
                            </a>
                        </div>
                    @endif

                    @if (auth()->user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm font-semibold text-slate-600 hover:text-indigo-600">Admin Panel</a>
                    @endif
                    @if (auth()->user()->role == 'dosen')
                        <a href="{{ route('dosen.dashboard') }}"
                            class="text-sm font-semibold text-slate-600 hover:text-indigo-600">Dosen Panel</a>
                    @endif

                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                        <a href="{{ route('profile.edit') }}" class="group flex items-center gap-2">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-slate-800 group-hover:text-indigo-600 transition">
                                    {{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold border border-indigo-200 group-hover:ring-2 ring-indigo-300 transition">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition" title="Logout">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-700">Login</a>
                @endguest
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 md:px-6 py-8">
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div
                class="mb-6 flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

</body>

</html>
