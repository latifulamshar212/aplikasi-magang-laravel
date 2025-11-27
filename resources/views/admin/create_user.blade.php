@extends('layout')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Tambah User Baru</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-blue-600">Kembali</a>
        </div>

        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Peran</label>
                <select name="role" id="roleSelect"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500" onchange="toggleDosen()">
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">NIM / NIP</label>
                <input type="text" name="nomor_induk" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500">
            </div>

            <div class="mb-6" id="dosenField">
                <label class="block text-sm font-medium text-gray-700 mb-2">Dosen Pembimbing</label>
                <select name="dosen_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500 bg-gray-50">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosenList as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">*Wajib dipilih jika peran adalah Mahasiswa</p>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition">
                Simpan User
            </button>
        </form>
    </div>

    <script>
        // Script sederhana untuk menyembunyikan input Dosen Pembimbing jika yang dipilih adalah Dosen
        function toggleDosen() {
            const role = document.getElementById('roleSelect').value;
            const dosenField = document.getElementById('dosenField');
            if (role === 'dosen') {
                dosenField.style.display = 'none';
            } else {
                dosenField.style.display = 'block';
            }
        }
    </script>
@endsection
