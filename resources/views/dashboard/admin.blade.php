@extends('layout')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen User</h2>
            <a href="{{ route('admin.user.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-bold">
                + Tambah User Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-gray-700">Nama</th>
                        <th class="p-4 font-semibold text-gray-700">NIM / NIP</th>
                        <th class="p-4 font-semibold text-gray-700">Role</th>
                        <th class="p-4 font-semibold text-gray-700 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">
                                <div class="font-bold text-gray-800">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </td>
                            <td class="p-4">{{ $user->nomor_induk }}</td>
                            <td class="p-4">
                                <span
                                    class="px-2 py-1 rounded text-xs font-bold uppercase
                            {{ $user->role == 'dosen' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini? Data logbook & absen akan ikut terhapus permanen!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="cursor-pointer text-red-500 hover:text-red-600 font-bold text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
