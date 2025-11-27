@extends('layout')

@section('content')
    <div class="grid md:grid-cols-3 gap-6">

        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Tulis Logbook</h2>

                {{-- LOGIKA: Hanya tampilkan form jika sudah Absen --}}
                @if ($todayAttendance)
                    <form action="{{ route('logbooks.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" readonly
                                class="w-full px-3 py-2 border border-gray-300 bg-gray-100 text-gray-500 rounded cursor-not-allowed">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kegiatan</label>
                            <textarea name="activity" rows="6" placeholder="Ceritakan apa yang Anda kerjakan hari ini..."
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500"></textarea>
                            <p class="text-xs text-gray-400 mt-1">Minimal 10 karakter.</p>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            Simpan Kegiatan
                        </button>
                    </form>
                @else
                    {{-- TAMPILAN JIKA BELUM ABSEN --}}
                    <div class="text-center py-8 bg-red-50 border border-red-200 rounded-lg">
                        <div class="text-5xl mb-4">🚫</div>
                        <h3 class="text-lg font-bold text-red-700 mb-2">Akses Terkunci</h3>
                        <p class="text-gray-600 text-sm px-4 mb-4">
                            Anda harus melakukan <b>Absen Masuk</b> terlebih dahulu sebelum bisa mengisi logbook harian.
                        </p>
                        <a href="{{ route('dashboard') }}"
                            class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                            Pergi ke Absensi
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="md:col-span-2">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Riwayat Jurnal</h2>

            <div class="space-y-4">
                @forelse($logbooks as $log)
                    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-bold text-lg text-gray-800">
                                {{ \Carbon\Carbon::parse($log->date)->translatedFormat('l, d F Y') }}
                            </span>
                            <span class="text-xs text-gray-400">
                                Diposting: {{ $log->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-gray-700 leading-relaxed whitespace-pre-line mb-4">{{ $log->activity }}</p>

                        @if ($log->feedback)
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 mt-4">
                                <h4 class="text-sm font-bold text-yellow-800 mb-1 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Feedback Dosen:
                                </h4>
                                <p class="text-sm text-yellow-900 italic">"{{ $log->feedback }}"</p>
                            </div>
                        @else
                            <div class="mt-2 text-xs text-gray-400 italic">Belum ada feedback dari dosen.</div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white p-8 rounded-lg shadow text-center text-gray-500">
                        <img src="https://img.icons8.com/ios/100/dddddd/open-book.png"
                            class="mx-auto mb-4 w-16 h-16 opacity-50" alt="Empty">
                        <p>Belum ada catatan logbook. Yuk mulai nulis!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
