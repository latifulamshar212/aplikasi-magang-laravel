@extends('layout')

@section('content')
    <div class="grid md:grid-cols-2 gap-6">

        <div class="bg-white p-6 rounded-lg shadow-md h-fit">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Absensi Hari Ini</h2>
            <p class="text-gray-500 mb-6">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>

            <div class="flex flex-col gap-4">
                {{-- LOGIKA TAMPILAN TOMBOL --}}
                @if (!$todayAttendance)
                    <div class="text-center py-4 bg-yellow-50 rounded border border-yellow-200">
                        <p class="text-yellow-800 mb-2">Anda belum melakukan absen masuk.</p>
                    </div>

                    <form action="{{ route('attendance.in') }}" method="POST">
                        @csrf
                        <button
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition">
                            Absen Masuk (07:30 - 08:00)
                        </button>
                    </form>
                @elseif($todayAttendance && !$todayAttendance->clock_out)
                    <div class="grid grid-cols-2 gap-4 text-center mb-4">
                        <div class="bg-green-50 p-3 rounded border border-green-200">
                            <span class="block text-xs text-gray-500">Jam Masuk</span>
                            <span class="font-bold text-xl text-green-700">{{ $todayAttendance->clock_in }}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border border-gray-200">
                            <span class="block text-xs text-gray-500">Status</span>
                            <span
                                class="font-bold uppercase {{ $todayAttendance->status == 'tepat_waktu' ? 'text-blue-600' : 'text-red-600' }}">
                                {{ str_replace('_', ' ', $todayAttendance->status) }}
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('attendance.out') }}" method="POST">
                        @csrf
                        <button
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded transition">
                            Absen Pulang (Min. 16:00)
                        </button>
                    </form>
                @else
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-center">
                        <p class="font-bold">Absensi Selesai!</p>
                        <p class="text-sm">Masuk: {{ $todayAttendance->clock_in }} | Pulang:
                            {{ $todayAttendance->clock_out }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md h-fit">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Riwayat Terakhir</h2>
                <a href="{{ route('report.print') }}" target="_blank"
                    class="bg-gray-800 hover:bg-gray-900 text-white text-sm px-4 py-2 rounded flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2-4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Masuk</th>
                            <th class="p-3">Pulang</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $row)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</td>
                                <td class="p-3">{{ $row->clock_in }}</td>
                                <td class="p-3">{{ $row->clock_out ?? '-' }}</td>
                                <td class="p-3">
                                    <span
                                        class="px-2 py-1 rounded text-xs text-white 
                                {{ $row->status == 'tepat_waktu' ? 'bg-blue-500' : 'bg-red-500' }}">
                                        {{ $row->status == 'tepat_waktu' ? 'Tepat' : 'Telat' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">Belum ada data absen.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
