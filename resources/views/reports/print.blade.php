<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Magang - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Trik agar saat di-print, tombol hilang */
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            background: white;
        }
    </style>
</head>

<body class="p-10 text-gray-800">

    <div class="no-print mb-6 text-right">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700">
            🖨️ Cetak / Simpan PDF
        </button>
        <a href="{{ route('dashboard') }}" class="text-gray-500 underline ml-4">Kembali</a>
    </div>

    <div class="text-center border-b-2 border-black pb-4 mb-6">
        <h1 class="text-2xl font-bold uppercase">Laporan Kegiatan Magang</h1>
        <p class="text-sm">Politeknik Negeri Lhokseumawe</p>
    </div>

    <div class="mb-6">
        <table class="w-full max-w-md">
            <tr>
                <td class="font-bold py-1 w-32">Nama</td>
                <td>: {{ $user->name }}</td>
            </tr>
            <tr>
                <td class="font-bold py-1">NIM</td>
                <td>: {{ $user->nomor_induk }}</td>
            </tr>
            <tr>
                <td class="font-bold py-1">Jurusan</td>
                <td>: {{ $user->student->jurusan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <h3 class="font-bold text-lg mb-2 border-l-4 border-black pl-2">A. Rekap Kehadiran</h3>
    <table class="w-full border-collapse border border-black mb-8 text-sm">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-black p-2">No</th>
                <th class="border border-black p-2">Tanggal</th>
                <th class="border border-black p-2">Masuk</th>
                <th class="border border-black p-2">Pulang</th>
                <th class="border border-black p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $row)
                <tr>
                    <td class="border border-black p-2 text-center">{{ $index + 1 }}</td>
                    <td class="border border-black p-2">
                        {{ \Carbon\Carbon::parse($row->date)->translatedFormat('d F Y') }}</td>
                    <td class="border border-black p-2 text-center">{{ $row->clock_in }}</td>
                    <td class="border border-black p-2 text-center">{{ $row->clock_out ?? '-' }}</td>
                    <td class="border border-black p-2 text-center uppercase">{{ str_replace('_', ' ', $row->status) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="border border-black p-2 text-center italic">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="break-inside-avoid"> {{-- Agar tabel tidak terpotong jelek saat pindah halaman --}}
        <h3 class="font-bold text-lg mb-2 border-l-4 border-black pl-2">B. Jurnal Kegiatan</h3>
        <table class="w-full border-collapse border border-black mb-8 text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-black p-2 w-10">No</th>
                    <th class="border border-black p-2 w-32">Tanggal</th>
                    <th class="border border-black p-2">Uraian Kegiatan</th>
                    <th class="border border-black p-2 w-48">Paraf / Feedback</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logbooks as $index => $log)
                    <tr>
                        <td class="border border-black p-2 text-center align-top">{{ $index + 1 }}</td>
                        <td class="border border-black p-2 align-top">
                            {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}</td>
                        <td class="border border-black p-2 align-top text-justify">{{ $log->activity }}</td>
                        <td class="border border-black p-2 align-top text-xs italic text-gray-600">
                            {{ $log->feedback ?? '(Belum dinilai)' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border border-black p-2 text-center italic">Tidak ada data logbook.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end mt-10 break-inside-avoid">
        <div class="text-center w-64">
            <p>Mengetahui,</p>
            <p class="mb-20">Dosen Pembimbing</p>
            <p class="font-bold underline">{{ $user->student->dosen->name ?? '.......................' }}</p>
            <p>NIP. {{ $user->student->dosen->nomor_induk ?? '.......................' }}</p>
        </div>
    </div>

</body>

</html>
