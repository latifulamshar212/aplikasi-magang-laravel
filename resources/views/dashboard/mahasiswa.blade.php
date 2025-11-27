@extends('layout')

@section('content')
    <div class="grid lg:grid-cols-3 gap-8">

        <div class="lg:col-span-1 space-y-6">

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold text-slate-800">Halo, {{ Str::words(Auth::user()->name, 1, '') }}! 👋</h2>
                <p class="text-slate-500 text-sm mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>

                <div class="mt-6 p-4 bg-indigo-50 rounded-xl flex items-center gap-4">
                    <div class="p-3 bg-white text-indigo-600 rounded-lg shadow-sm">
                        ⏰
                    </div>
                    <div>
                        <p class="text-xs text-indigo-600 font-bold uppercase tracking-wider">Jam Server</p>
                        <p class="text-2xl font-bold text-slate-800">{{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full"></span> Status Kehadiran
                </h3>

                @if (!$todayAttendance)
                    <div class="text-center py-6">
                        <div
                            class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                            ⚠️</div>
                        <p class="text-slate-600 mb-6 px-4">Anda belum melakukan presensi masuk hari ini.</p>
                        <form action="{{ route('attendance.in') }}" method="POST">
                            @csrf
                            <button
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-200 transition">
                                Absen Masuk Sekarang
                            </button>
                            <p class="text-xs text-slate-400 mt-2">Batas waktu: 08:00 WIB</p>
                        </form>
                    </div>
                @elseif($todayAttendance && !$todayAttendance->clock_out)
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100 text-center">
                            <p class="text-xs text-emerald-600 font-bold mb-1">JAM MASUK</p>
                            <p class="text-xl font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($todayAttendance->clock_in)->format('H:i') }}</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <p class="text-xs text-slate-500 font-bold mb-1">STATUS</p>
                            <span
                                class="px-2 py-0.5 rounded text-xs font-bold uppercase {{ $todayAttendance->status == 'tepat_waktu' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }}">
                                {{ $todayAttendance->status }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('attendance.out') }}" method="POST">
                        @csrf
                        <button
                            class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-rose-200 transition">
                            Absen Pulang
                        </button>
                        <p class="text-xs text-slate-400 mt-2 text-center">Dibuka mulai 16:00 WIB</p>
                    </form>
                @else
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 text-center">
                        <div class="text-4xl mb-2">✅</div>
                        <h4 class="font-bold text-emerald-800 text-lg">Kehadiran Tuntas!</h4>
                        <p class="text-emerald-600 text-sm mt-1">Sampai jumpa besok.</p>
                        <div class="flex justify-center gap-4 mt-4 text-sm font-medium">
                            <span>IN: {{ $todayAttendance->clock_in }}</span>
                            <span>OUT: {{ $todayAttendance->clock_out }}</span>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-lg">Riwayat Presensi</h3>
                    <a href="{{ route('report.print') }}" target="_blank"
                        class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download PDF
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                <th class="p-4 font-semibold">Tanggal</th>
                                <th class="p-4 font-semibold">Jam Masuk</th>
                                <th class="p-4 font-semibold">Jam Pulang</th>
                                <th class="p-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($history as $row)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4 font-medium text-slate-700">
                                        {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                                    </td>
                                    <td class="p-4 text-slate-600">{{ $row->clock_in }}</td>
                                    <td class="p-4 text-slate-600">{{ $row->clock_out ?? '--:--' }}</td>
                                    <td class="p-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $row->status == 'tepat_waktu' ? 'bg-indigo-50 text-indigo-600' : 'bg-orange-50 text-orange-600' }}">
                                            {{ $row->status == 'tepat_waktu' ? 'On Time' : 'Late' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-slate-400">
                                        Belum ada data riwayat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
