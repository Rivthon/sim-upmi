@extends('layouts.user')

@section('title', 'Unggah Dokumen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Unggah Dokumen Mutu</h2>
        
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

        <form action="{{ route('user.dokumen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Dokumen / Judul --}}
            <div class="mb-5">
                <label for="judul" class="block text-gray-700 text-sm font-semibold mb-2">Nama Dokumen</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('judul') border-red-500 @enderror" required>
                @error('judul') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kode --}}
            <div class="mb-5">
                <label for="kode_dokumen" class="block text-gray-700 text-sm font-semibold mb-2">Kode</label>
                <input type="text" name="kode_dokumen" id="kode_dokumen" value="{{ old('kode_dokumen') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('kode_dokumen') border-red-500 @enderror">
                @error('kode_dokumen') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tahun Terbit --}}
            <div class="mb-5">
                <label for="tanggal_terbit" class="block text-gray-700 text-sm font-semibold mb-2">Tahun Terbit</label>
                <input type="date" name="tanggal_terbit" id="tanggal_terbit" value="{{ old('tanggal_terbit') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('tanggal_terbit') border-red-500 @enderror" required>
                @error('tanggal_terbit') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Versi --}}
            <div class="mb-5">
                <label for="versi" class="block text-gray-700 text-sm font-semibold mb-2">Versi</label>
                <input type="text" name="versi" id="versi" value="{{ old('versi') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('versi') border-red-500 @enderror">
                @error('versi') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
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

            {{-- Sub Kategori Dokumen (Nested with Optgroup) --}}
            <div class="mb-5">
                <label for="sub_kategori_id" class="block text-gray-700 text-sm font-semibold mb-2">Sub Kategori Dokumen</label>
                <select name="sub_kategori_id" id="sub_kategori_id" 
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('sub_kategori_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Sub Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <optgroup label="{{ $kategori->nama }} ({{ ucfirst($kategori->tipe) }})">
                            @foreach ($kategori->subKategoris as $sub)
                                <option value="{{ $sub->id }}" {{ old('sub_kategori_id') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->nama }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('sub_kategori_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- File Dokumen (PDF/DOC) --}}
            <div class="mb-6">
                <label for="file_path" class="block text-gray-700 text-sm font-semibold mb-2">File Dokumen (PDF/DOC/DOCX)</label>
                <input type="file" name="file_path" id="file_path" accept=".pdf,.doc,.docx"
                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('file_path') border-red-500 @enderror" required>
                <p class="text-sm text-gray-500 mt-2">Format file yang diterima: PDF, DOC, DOCX.</p>
                @error('file_path') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('user.dokumen.index') }}"
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
                    Simpan Dokumen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection