@extends('layouts.admin')

@section('title', 'Detail Dokumen Mutu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        {{-- Header Card --}}
        <div class="bg-blue-600 text-white p-5 sm:p-6 flex justify-between items-center">
            <h5 class="text-2xl sm:text-3xl font-extrabold">Detail Dokumen Mutu</h5>
            <a href="{{ route('admin.dokumen.index') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        {{-- Content Detail --}}
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-base mb-8">
                {{-- Baris 1 --}}
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Kode Dokumen</p>
                    <p class="text-gray-900 text-lg font-medium">{{ $dokumen->kode_dokumen }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Judul</p>
                    <p class="text-gray-900 text-lg">{{ $dokumen->judul }}</p>
                </div>

                {{-- Baris 2 --}}
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Kategori</p>
                    <p class="text-gray-900 text-lg">{{ $dokumen->kategori->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Sub Kategori</p>
                    <p class="text-gray-900 text-lg">{{ $dokumen->subKategori->nama ?? '-' }}</p>
                </div>

                {{-- Baris 3 --}}
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Versi</p>
                    <p class="text-gray-900 text-lg">{{ $dokumen->versi }}</p>
                </div>
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Tanggal Terbit</p>
                    <p class="text-gray-900 text-lg">{{ $dokumen->tanggal_terbit ? \Carbon\Carbon::parse($dokumen->tanggal_terbit)->format('d F Y') : '-' }}</p>
                </div>

                {{-- Baris 4 --}}
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Status</p>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-base font-semibold leading-tight
                        {{ $dokumen->status === 'Aktif' ? 'bg-green-100 text-green-800' : ($dokumen->status === 'Revisi' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $dokumen->status }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Tipe Dokumen</p>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-base font-semibold leading-tight
                        {{ $dokumen->tipe === 'Publik' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ $dokumen->tipe }}
                    </span>
                </div>
                
                {{-- Baris 5 (Diunggah Oleh & Revisi Dari) --}}
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Diunggah Oleh</p>
                    <p class="text-gray-900 text-lg">{{ $dokumen->uploader->name ?? '-' }}</p>
                </div>
                @if ($dokumen->revisi_dari)
                    <div>
                        <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Revisi Dari</p>
                        <a href="{{ route('admin.dokumen.show', $dokumen->revisi_dari) }}" class="text-blue-600 hover:underline text-lg flex items-center">
                            <svg class="w-5 h-5 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            {{ $dokumen->dokumenAsal->kode_dokumen ?? 'ID: '.$dokumen->revisi_dari }}
                        </a>
                    </div>
                @else
                    <div>
                        <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Revisi Dari</p>
                        <p class="text-gray-900 text-lg">-</p>
                    </div>
                @endif
            </div>

            {{-- Deskripsi --}}
            @if ($dokumen->deskripsi)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-3">Deskripsi</p>
                    <p class="text-gray-900 text-lg whitespace-pre-line leading-relaxed">
                        {{ $dokumen->deskripsi }}
                    </p>
                </div>
            @endif

            {{-- Histori Revisi --}}
            @if ($revisiAnak->count() > 0)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-l-4 border-gray-400 pl-4">Histori Revisi Dokumen Ini</h3>
                    <div class="space-y-4">
                        @foreach ($revisiAnak as $revisi)
                            <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 shadow-sm flex items-start space-x-4">
                                <svg class="w-6 h-6 text-gray-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.293 2.293a1 1 0 001.414-1.414L10 10.586V7a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <div>
                                    <p class="text-lg font-semibold text-gray-800">
                                        Versi: {{ $revisi->versi }} | Kode:
                                        <a href="{{ route('admin.dokumen.show', $revisi->id) }}" class="text-blue-600 hover:underline">
                                            {{ $revisi->kode_dokumen }}
                                        </a>
                                    </p>
                                    <p class="text-gray-700 mt-1">
                                        <span class="font-medium">Tanggal Revisi:</span> {{ \Carbon\Carbon::parse($revisi->created_at)->format('d F Y H:i') }}
                                    </p>
                                    <p class="text-gray-700">
                                        <span class="font-medium">Diunggah Oleh:</span> {{ $revisi->uploader->name ?? '-' }}
                                    </p>
                                    @if ($revisi->deskripsi)
                                        <p class="text-gray-600 text-sm mt-2">
                                            <span class="font-medium">Deskripsi Revisi:</span> {{ Str::limit($revisi->deskripsi, 100) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- File Dokumen --}}
            <div class="mt-8 pt-6 border-t-2 border-blue-500">
                <p class="text-gray-500 font-semibold text-sm uppercase mb-3">File Dokumen</p>
                @if ($dokumen->file_path)
                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                        <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Lihat / Unduh File (PDF)
                    </a>
                @else
                    <p class="text-gray-500 text-lg italic">Tidak ada file dokumen yang diunggah.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection