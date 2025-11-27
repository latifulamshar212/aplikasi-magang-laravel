@extends('layout')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Mahasiswa Bimbingan</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-300">
                        <th class="p-4 font-semibold text-gray-700">Nama Mahasiswa</th>
                        <th class="p-4 font-semibold text-gray-700">NIM</th>
                        <th class="p-4 font-semibold text-gray-700">Kelas / Jurusan</th>
                        <th class="p-4 font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $mhs)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">
                                <div class="font-bold text-gray-800">{{ $mhs->name }}</div>
                                <div class="text-sm text-gray-500">{{ $mhs->email }}</div>
                            </td>
                            <td class="p-4">{{ $mhs->nomor_induk }}</td>
                            <td class="p-4">
                                {{ $mhs->student->kelas ?? '-' }} <br>
                                <span class="text-xs text-gray-500">{{ $mhs->student->jurusan ?? '-' }}</span>
                            </td>
                            <td class="p-4">
                                <a href="{{ route('dosen.student.show', $mhs->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-bold transition">
                                    Periksa Jurnal
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">
                                Belum ada mahasiswa bimbingan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
