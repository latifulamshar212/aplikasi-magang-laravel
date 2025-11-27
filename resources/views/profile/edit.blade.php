@extends('layout')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">Pengaturan Akun</h2>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-100">
                <label class="block text-sm font-bold text-blue-800 mb-1">Nomor Induk (NIM / NIP)</label>
                <p class="text-gray-700 font-mono">{{ $user->nomor_induk }}</p>
                <p class="text-xs text-gray-500 mt-1">*Nomor induk tidak dapat diubah.</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Ganti Password</h3>
            <p class="text-sm text-gray-500 mb-4">Kosongkan jika tidak ingin mengubah password.</p>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="password" autocomplete="new-password"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ulangi Password Baru</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded transition">
                    Batal
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
