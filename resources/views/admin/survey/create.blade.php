@extends('layouts.admin')

@section('title', 'Buat Survei Kepuasan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Buat Survei Kepuasan</h2>
        
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

        <form action="{{ route('admin.survey.store') }}" method="POST">
            @csrf

            {{-- Judul --}}
            <div class="mb-5">
                <label for="judul" class="block text-gray-700 text-sm font-semibold mb-2">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('judul') border-red-500 @enderror" required>
                @error('judul') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-5">
                <label for="deskripsi" class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                          class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                 transition duration-200 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>
@php
    $selectedTargets = old('target', []); // Kalau kamu mau tambah edit, tinggal ubah sesuai data dari DB
@endphp
            {{-- Target Survei --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Target Survei</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="inline-flex items-center text-gray-700 text-base cursor-pointer">
<input type="checkbox" name="target[]" value="Prodi D3 Kebidanan" {{ in_array('Prodi D3 Kebidanan', $selectedTargets) ? 'checked' : '' }}>
                        <span class="ml-2">Prodi D3 Kebidanan</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700 text-base cursor-pointer">
<input type="checkbox" name="target[]" value="Prodi S1 Farmasi" {{ in_array('Prodi S1 Farmasi', $selectedTargets) ? 'checked' : '' }}>
                        <span class="ml-2">Prodi S1 Farmasi</span>
                    </label>       
                    <label class="inline-flex items-center text-gray-700 text-base cursor-pointer">
<input type="checkbox" name="target[]" value="Prodi S1 Gizi" {{ in_array('Prodi S1 Gizi', $selectedTargets) ? 'checked' : '' }}>
                        <span class="ml-2">Prodi S1 Gizi</span>
                    </label>                                  
                    <label class="inline-flex items-center text-gray-700 text-base cursor-pointer">
<input type="checkbox" name="target[]" value="Tendik" {{ in_array('Tendik', $selectedTargets) ? 'checked' : '' }}>
                        <span class="ml-2">Tendik</span>
                    </label>
                    <label class="inline-flex items-center text-gray-700 text-base cursor-pointer">
<input type="checkbox" name="target[]" value="Mahasiswa" {{ in_array('Mahasiswa', $selectedTargets) ? 'checked' : '' }}>
                        <span class="ml-2">Mahasiswa</span>
                    </label>
                </div>
                @error('target') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.survey.index') }}"
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
                    Simpan Survei
                </button>
            </div>
        </form>
    </div>
</div>
@endsection