@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Edit Berita & Pengumuman</h2>
        
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

        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Judul Berita --}}
            <div class="mb-5">
                <label for="judul" class="block text-gray-700 text-sm font-semibold mb-2">Judul Berita</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $berita->judul) }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('judul') border-red-500 @enderror" required>
                @error('judul') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Narasi Lengkap --}}
            <div class="mb-5">
                <label for="narasi" class="block text-gray-700 text-sm font-semibold mb-2">Narasi Lengkap</label>
                <textarea id="narasi" name="narasi" rows="10"
                          class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                 transition duration-200 @error('narasi') border-red-500 @enderror">{{ old('narasi', $berita->narasi) }}</textarea>
                @error('narasi') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Gambar Saat Ini --}}
            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Gambar Saat Ini</label>
                @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" 
                         class="w-40 h-auto object-cover rounded-lg shadow-md mb-2 border border-gray-200"> {{-- Ukuran dan styling lebih baik --}}
                @else
                    <p class="text-sm text-gray-500 italic">Tidak ada gambar yang diunggah.</p>
                @endif
            </div>

            {{-- Ganti Gambar (Opsional) --}}
            <div class="mb-6">
                <label for="gambar" class="block text-gray-700 text-sm font-semibold mb-2">Ganti Gambar (Opsional)</label>
                <input type="file" name="gambar" id="gambar" accept="image/*"
                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('gambar') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar. Format yang diterima: JPG, PNG, GIF.</p>
                @error('gambar') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.berita.index') }}"
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
                    Perbarui Berita
                </button>
            </div>
        </form>
    </div>
</div>
@endsection