@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Detail Pelaporan SPMI</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-base mb-8">
            {{-- Judul --}}
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Judul</p>
                <p class="text-gray-900 text-lg font-medium">{{ $pelaporan->judul }}</p>
            </div>
            {{-- Unit --}}
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Unit</p>
                <p class="text-gray-900 text-lg font-medium">{{ $pelaporan->unit }}</p>
            </div>
            {{-- Periode --}}
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Periode</p>
                <p class="text-gray-900 text-lg">{{ $pelaporan->periode }}</p>
            </div>
            {{-- Tahapan --}}
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Tahapan</p>
                <p class="text-gray-900 text-lg">{{ $pelaporan->tahapan }}</p>
            </div>
            {{-- Tanggal --}}
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Tanggal</p>
                <p class="text-gray-900 text-lg">{{ \Carbon\Carbon::parse($pelaporan->tanggal)->format('d F Y') }}</p>
            </div>
            {{-- Status --}}
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Status</p>
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-base font-semibold leading-tight
                    {{ $pelaporan->status === 'Draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ $pelaporan->status }}
                </span>
            </div>
            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Deskripsi</p>
                <p class="text-gray-900 text-lg leading-relaxed whitespace-pre-line">{{ $pelaporan->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
            {{-- Bukti Pendukung --}}
            <div class="md:col-span-2">
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Bukti Pendukung</p>
                @if ($pelaporan->bukti_pendukung)
                    <a href="{{ route('admin.pelaporan.download', $pelaporan->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-200 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Lihat Dokumen
                    </a>
                @else
                    <p class="text-gray-500 text-lg italic">Tidak ada file bukti pendukung yang diunggah.</p>
                @endif
            </div>
        </div>

        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mt-8 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.pelaporan.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
            {{-- Tombol Edit (opsional, jika ada rute edit) --}}
            {{-- <a href="{{ route('admin.pelaporan.edit', $pelaporan->id) }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Laporan
            </a> --}}
        </div>
    </div>
</div>
@endsection
