@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Detail Dokumen</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-base">
            <div>
                <p class="text-sm text-gray-600 font-semibold">Judul</p>
                <p class="text-lg text-gray-800">{{ $dokumen->judul }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-semibold">Tipe</p>
                <span class="inline-block px-3 py-1 rounded-full text-white text-sm 
                    {{ $dokumen->tipe === 'Publik' ? 'bg-green-500' : 'bg-yellow-500' }}">
                    {{ $dokumen->tipe }}
                </span>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-semibold">Kategori</p>
                <p class="text-lg text-gray-800">{{ $dokumen->kategoriDokumen->nama ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 font-semibold">Sub Kategori</p>
                <p class="text-lg text-gray-800">{{ $dokumen->subKategoriDokumen->nama ?? '-' }}</p>
            </div>

            <div class="sm:col-span-2 mt-4">
                <p class="text-sm text-gray-600 font-semibold">Deskripsi Kategori</p>
                <p class="text-gray-800">{{ $dokumen->kategoriDokumen->deskripsi ?? '-' }}</p>
            </div>
        </div>

        {{-- Link File --}}
        <div class="mt-6 border-t pt-4">
            <p class="text-sm text-gray-600 font-semibold mb-2">File Dokumen</p>
            @if ($dokumen->file_path)
                <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank"
                   class="inline-flex items-center text-blue-600 hover:underline">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1 4v-4m6 4v-6a2 2 0 00-2-2H9m4 8h1m0-4V4H5a2 2 0 00-2 2v12a2 2 0 002 2h6l2 2 2-2h1z"/>
                    </svg>
                    Lihat / Unduh Dokumen
                </a>
            @else
                <p class="text-gray-500 italic">File belum tersedia.</p>
            @endif
        </div>

        {{-- Tombol Navigasi --}}
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('admin.dokumen-upload.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded">
                Kembali
            </a>
            <a href="{{ route('admin.dokumen-upload.edit', $dokumen->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded">
                Edit Dokumen
            </a>
        </div>
    </div>
</div>
@endsection
