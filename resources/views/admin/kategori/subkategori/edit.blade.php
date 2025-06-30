@extends('layouts.admin')

@section('title', 'Edit Sub Kategori Dokumen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Edit Sub Kategori Dokumen</h2>

        {{-- Pesan Sukses --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

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

        <form action="{{ route('admin.subkategori.update', $subkategori->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kategori Dokumen --}}
            <div class="mb-5">
                <label for="kategori_dokumen_id" class="block text-gray-700 text-sm font-semibold mb-2">Kategori Dokumen</label>
                <select name="kategori_dokumen_id" id="kategori_dokumen_id"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('kategori_dokumen_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_dokumen_id', $subkategori->kategori_dokumen_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }} - {{ ucfirst($kategori->tipe) }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_dokumen_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nama Sub Kategori --}}
            <div class="mb-6">
                <label for="nama" class="block text-gray-700 text-sm font-semibold mb-2">Nama Sub Kategori</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $subkategori->nama) }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('nama') border-red-500 @enderror" required>
                @error('nama') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.subkategori.index') }}"
                   class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm
                          transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center bg-yellow-500 text-white font-bold py-2.5 px-6 rounded-lg shadow-md
                               hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2
                               transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Update Sub Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection