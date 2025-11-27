@extends('layout')

@section('content')
    <div class="flex items-center justify-center min-h-screen pt-4 pb-10">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-xl border border-gray-200">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6">
                Login Sistem Magang
            </h2>

            <form method="POST" action="/login">
                @csrf

                <div class="mb-4">
                    <label for="login" class="block text-sm font-medium text-gray-700">
                        NIM / NIP / Email
                    </label>
                    <input id="login" type="text" name="login" required autofocus value="{{ old('login') }}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                    @error('login')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <button type="submit"
                        class="cursor-pointer w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
