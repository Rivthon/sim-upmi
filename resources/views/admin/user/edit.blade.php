@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Edit Pengguna</h2>

        {{-- Pesan Error Umum --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-md" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-bold">Terjadi Kesalahan!</p>
                </div>
                <ul class="mt-2 text-sm list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-5">
                <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('name') border-red-500 @enderror" required>
                @error('name') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('email') border-red-500 @enderror" required>
                @error('email') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="mb-5">
                <label for="tanggal_lahir" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('tanggal_lahir') border-red-500 @enderror">
                @error('tanggal_lahir') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Unit --}}
            <div class="mb-5">
                <label for="unit" class="block text-gray-700 text-sm font-semibold mb-2">Unit</label>
                <select name="unit" id="unit" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('unit') border-red-500 @enderror">
                    <option value="">Pilih Unit</option>
                    <option value="Prodi D3 Kebidanan" {{ old('unit', $user->unit) == 'Prodi D3 Kebidanan' ? 'selected' : '' }}>Prodi D3 Kebidanan</option>
                    <option value="Prodi S1 Farmasi" {{ old('unit', $user->unit) == 'Prodi S1 Farmasi' ? 'selected' : '' }}>Prodi S1 Farmasi</option>
                    <option value="Prodi S1 Gizi" {{ old('unit', $user->unit) == 'Prodi S1 Gizi' ? 'selected' : '' }}>Prodi S1 Gizi</option>
                    <option value="Tendik" {{ old('unit', $user->unit) == 'Tendik' ? 'selected' : '' }}>Tendik</option>
                    <option value="Admin" {{ old('unit', $user->unit) == 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('unit') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>


            {{-- Roles --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Role</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($roles as $role)
                        <label class="inline-flex items-center text-gray-700 text-base cursor-pointer">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                   class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300 transition duration-150 ease-in-out"
                                   {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            <span class="ml-2">{{ ucwords(str_replace('-', ' ', $role->name)) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('roles') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password (Optional) --}}
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password (Kosongkan jika tidak ingin diubah)</label>
                <input type="password" id="password" name="password"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('password') border-red-500 @enderror">
                @error('password') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('admin.user.index') }}"
                   class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm
                          transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center bg-blue-600 text-white font-bold py-2.5 px-6 rounded-lg shadow-md
                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Update Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection