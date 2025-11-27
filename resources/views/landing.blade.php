<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Magang</title>
    {{-- Gunakan font Inter agar senada dengan Dashboard --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <nav class="flex justify-between items-center p-6 container mx-auto relative z-20">
        <div class="text-2xl font-bold text-indigo-700 flex items-center gap-2 tracking-tighter">
            <span class="bg-indigo-600 text-white w-8 h-8 flex items-center justify-center rounded-lg text-lg">M</span>
            <span>MagangApp</span>
        </div>

        <div>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-full font-bold transition shadow-md hover:shadow-lg ring-2 ring-indigo-600 ring-offset-2">
                    Dashboard Saya &rarr;
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-full font-bold transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Login Akun
                </a>
            @endauth
        </div>
    </nav>

    <header
        class="container mx-auto px-6 py-16 md:py-24 text-center md:text-left flex flex-col md:flex-row items-center relative z-10">

        <div class="md:w-1/2">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight text-gray-900 mb-6">
                Kelola Kegiatan
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Magang</span>
                Jadi Lebih Mudah.
            </h1>
            <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg mx-auto md:mx-0">
                Platform terintegrasi untuk absensi kehadiran, pelaporan logbook harian, dan bimbingan dosen secara
                realtime.
            </p>

            <div class="flex flex-col md:flex-row gap-4 justify-center md:justify-start">
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-center px-8 py-4 rounded-xl font-bold text-lg shadow-xl shadow-indigo-200 transition transform hover:-translate-y-1">
                        Mulai Sekarang
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="bg-emerald-500 hover:bg-emerald-600 text-white text-center px-8 py-4 rounded-xl font-bold text-lg shadow-xl shadow-emerald-200 transition transform hover:-translate-y-1">
                        Lanjut Mengisi Jurnal
                    </a>
                @endguest
            </div>
        </div>

        <div class="md:w-1/2 mt-12 md:mt-0 relative">
            <div
                class="bg-indigo-100 rounded-full w-full aspect-square absolute -z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-50 blur-3xl scale-110">
            </div>

            <img src="https://img.freepik.com/free-vector/internship-job-concept-illustration_114360-6782.jpg"
                alt="Ilustrasi Magang"
                class="w-full max-w-md mx-auto drop-shadow-2xl rounded-2xl border-4 border-white transform rotate-2 hover:rotate-0 transition duration-500">

            <a href="https://www.freepik.com" target="_blank"
                class="block text-xs text-center text-gray-400 mt-4 hover:text-indigo-500 transition">
                Ilustrasi oleh Freepik
            </a>
        </div>
    </header>

    <section class="bg-white py-24 border-t border-gray-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm">Kenapa Kami?</span>
                <h2 class="text-3xl md:text-4xl font-extrabold mt-2 text-gray-900">Fitur Unggulan</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-10">
                <div
                    class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 bg-gray-50 group">
                    <div
                        class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        ⏰</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Presensi Online</h3>
                    <p class="text-gray-600 leading-relaxed">Absen masuk dan pulang terekam otomatis dengan validasi
                        waktu server yang akurat.</p>
                </div>
                <div
                    class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 bg-gray-50 group">
                    <div
                        class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        📖</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Logbook Harian</h3>
                    <p class="text-gray-600 leading-relaxed">Catat kegiatan harianmu dengan mudah, lampirkan progres,
                        dan dapatkan feedback.</p>
                </div>
                <div
                    class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition duration-300 bg-gray-50 group">
                    <div
                        class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition">
                        👨‍🏫</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Monitoring Dosen</h3>
                    <p class="text-gray-600 leading-relaxed">Dosen pembimbing dapat memantau kehadiran dan kinerja
                        mahasiswa bimbingan secara realtime.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-10 border-t border-gray-800">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-2xl font-bold mb-4">MagangApp</h3>
            <p class="text-gray-400 mb-6">Membangun masa depan karir digital Anda.</p>
            <hr class="border-gray-800 mb-6 w-1/4 mx-auto">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Sistem Informasi Magang. All rights reserved.
            </p>
        </div>
    </footer>

</body>

</html>
