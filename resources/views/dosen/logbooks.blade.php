@extends('layout')

@section('content')
    <div class="mb-6">
        <a href="{{ route('dosen.dashboard') }}" class="text-blue-600 hover:underline mb-2 inline-block">&larr; Kembali ke
            Dashboard</a>
        <h2 class="text-2xl font-bold text-gray-800">Jurnal Kegiatan: {{ $student->name }}</h2>
        <p class="text-gray-500">{{ $student->nomor_induk }} - {{ $student->student->jurusan ?? '' }}</p>
    </div>

    <div class="space-y-6">
        @forelse($logbooks as $log)
            <div
                class="bg-white p-6 rounded-lg shadow-md border-l-4 {{ $log->feedback ? 'border-green-500' : 'border-gray-300' }}">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="font-bold text-lg text-gray-800 block">
                            {{ \Carbon\Carbon::parse($log->date)->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="text-xs text-gray-400">
                            Diposting: {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div
                        class="px-3 py-1 rounded text-xs font-bold {{ $log->feedback ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $log->feedback ? 'Sudah Dinilai' : 'Belum Dinilai' }}
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded mb-4 border border-gray-100">
                    <p class="text-gray-800 whitespace-pre-line">{{ $log->activity }}</p>
                </div>

                <form action="{{ route('dosen.feedback.store', $log->id) }}" method="POST">
                    @csrf
                    <label class="block text-sm font-bold text-gray-700 mb-1">Feedback Anda:</label>

                    <div class="flex gap-2">
                        <input type="text" name="feedback" value="{{ $log->feedback }}"
                            placeholder="Berikan masukan atau komentar..."
                            class="flex-1 px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm">

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        @empty
            <div class="bg-white p-8 rounded-lg shadow text-center text-gray-500">
                <p>Mahasiswa ini belum menulis logbook apapun.</p>
            </div>
        @endforelse
    </div>
@endsection
