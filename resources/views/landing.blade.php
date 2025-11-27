<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Magang</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite('resources/css/app.css', 'resources/js/app.js')
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    <nav class="flex justify-between items-center p-6 container mx-auto">
        <div class="text-2xl font-bold text-blue-700">MagangApp</div>
        <div>
            @auth
                <a href="{{ route('dashboard') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-bold transition">
                    Dashboard Saya
                </a>
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-bold mr-4">Masuk</a>
                <a href="{{ route('login') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full font-bold transition">
                    Login Peserta
                </a>
            @endauth
        </div>
    </nav>

    <header class="container mx-auto px-6 py-16 text-center md:text-left flex flex-col md:flex-row items-center">
        <div class="md:w-1/2">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight text-gray-900 mb-6">
                Kelola Kegiatan <span class="text-blue-600">Magang</span> Jadi Lebih Mudah.
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Platform terintegrasi untuk absensi kehadiran, pelaporan logbook harian, dan bimbingan dosen secara
                realtime.
            </p>
            <div class="flex flex-col md:flex-row gap-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-center px-8 py-3 rounded-lg font-bold text-lg shadow-lg transition transform hover:-translate-y-1">
                        Mulai Sekarang
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="bg-green-600 hover:bg-green-700 text-white text-center px-8 py-3 rounded-lg font-bold text-lg shadow-lg transition">
                        Lanjut Mengisi Jurnal
                    </a>
                @endguest
            </div>
        </div>

        <div class="md:w-1/2 mt-12 md:mt-0 relative">
            <div class="bg-blue-100 rounded-full w-full aspect-square absolute -z-10 top-0 right-0 opacity-50 blur-3xl">
            </div>
            <img src="https://img.freepik.com/free-vector/internship-job-concept-illustration_114360-6782.jpg"
                alt="Ilustrasi Magang" class="w-full max-w-md mx-auto drop-shadow-2xl rounded-xl">
            <p class="text-xs text-center text-gray-400 mt-2">Image by Freepik</p>
        </div>
    </header>

    <section class="bg-white py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Fitur Unggulan</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition bg-gray-50">
                    <div class="text-4xl mb-4">⏰</div>
                    <h3 class="text-xl font-bold mb-2">Presensi Online</h3>
                    <p class="text-gray-600">Absen masuk dan pulang terekam otomatis dengan validasi waktu yang akurat.
                    </p>
                </div>
                <div class="p-6 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition bg-gray-50">
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-xl font-bold mb-2">Logbook Harian</h3>
                    <p class="text-gray-600">Catat kegiatan harianmu dengan mudah dan dapatkan feedback langsung dari
                        dosen.</p>
                </div>
                <div class="p-6 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition bg-gray-50">
                    <div class="text-4xl mb-4">👨‍🏫</div>
                    <h3 class="text-xl font-bold mb-2">Monitoring Dosen</h3>
                    <p class="text-gray-600">Dosen pembimbing dapat memantau progres mahasiswa bimbingan secara
                        realtime.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-8 text-center">
        <p>&copy; {{ date('Y') }} Sistem Informasi Magang. All rights reserved.</p>
    </footer>

</body>

</html>
