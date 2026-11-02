@extends('layouts.user')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Selamat Datang, <span class="text-blue-600">{{ Auth::user()->name }}</span>!</h2>

    {{-- Jadwal Audit Mutu Internal (AMI) --}}
    <div class="mb-10 p-6 bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="flex items-center mb-6 pb-4 border-b border-blue-100">
            <svg class="w-8 h-8 mr-3 text-blue-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-2xl font-bold text-blue-700">Jadwal Audit Mutu Internal (AMI)</h3>
        </div>
        
        @forelse($jadwalAmi as $jadwal)
            <div class="p-4 bg-gray-50 rounded-lg shadow-sm border border-gray-100 mb-4 transition duration-200 ease-in-out hover:shadow-md">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-base">
                    <div>
                        <p class="text-gray-600 font-semibold">Unit</p>
                        <p class="text-gray-900">{{ $jadwal->unit }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-semibold">Sub Unit</p>
                        <p class="text-gray-900">{{ $jadwal->sub_unit ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-gray-600 font-semibold">Tanggal Audit</p>
                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($jadwal->tanggal_selesai)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-4 text-center bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-600 italic text-lg">Belum ada jadwal Audit Mutu Internal untuk unit Anda saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Survei Kepuasan --}}
    <div class="mb-10 p-6 bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="flex items-center mb-6 pb-4 border-b border-green-100">
            <svg class="w-8 h-8 mr-3 text-green-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-12a1 1 0 10-2 0v4a1 1 0 00.293.707L7.5 11.586l.707.707A1 1 0 009 12.586l2.293-2.293A1 1 0 0012.586 9l-.707-.707a1 1 0 00-1.414 0L10 9.586V7a1 1 0 10-2 0z" clip-rule="evenodd"></path></svg>
            <h3 class="text-2xl font-bold text-green-700">Survei Kepuasan yang Tersedia</h3>
        </div>
        
    @if($surveys->count() > 0)
        <div class="grid gap-6">
            @foreach($surveys as $survey)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $survey->judul }}</h3>
                    <p class="text-gray-600 mt-1">{{ $survey->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                    {{-- Tampilkan status pengisian jika tersedia --}}
                    @if($survey->sudah_isi)
                        <p class="mt-4 text-green-600 font-medium">Anda sudah mengisi survei ini.</p>
                    @else
                        <a href="{{ route('user.survey.fill', $survey->id) }}"
                           class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                            Isi Survei
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Tidak ada survei yang tersedia untuk Anda saat ini.</p>
    @endif
    </div>

    {{-- Dokumen Mutu Anda --}}
    <div class="p-6 bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="flex items-center mb-6 pb-4 border-b border-purple-100">
            <svg class="w-8 h-8 mr-3 text-purple-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
            <h3 class="text-2xl font-bold text-purple-700">Dokumen Mutu yang Anda Unggah</h3>
        </div>
        
        @forelse($dokumenUser as $dok)
            <div class="p-4 bg-gray-50 rounded-lg shadow-sm border border-gray-100 mb-4 transition duration-200 ease-in-out hover:shadow-md">
                <h4 class="font-bold text-lg text-gray-900 mb-1">{{ $dok->judul }}</h4>
                <p class="text-sm text-gray-600 mb-2">
                    <span class="font-medium">Kode:</span> {{ $dok->kode_dokumen ?? '-' }} |
                    <span class="font-medium">Kategori:</span> {{ $dok->subKategori->nama ?? $dok->kategori->nama ?? '-' }} |
                    <span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($dok->created_at)->format('d F Y') }}
                </p>
                <a href="{{ route('user.dokumen.download', $dok->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Lihat / Unduh Dokumen
                </a>
            </div>
        @empty
            <div class="p-4 text-center bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-600 italic text-lg">Anda belum mengunggah dokumen mutu apapun.</p>
                <div class="mt-4">
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
