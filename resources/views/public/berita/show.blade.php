@extends('layouts.public')

@section('title', $berita->judul . ' - UPMI STIKes Bogor Husada')

@section('content')
<div class="container mx-auto px-4 py-8 md:py-12">
    {{-- Breadcrumbs --}}
    <nav class="text-sm font-medium text-gray-500 mb-6 md:mb-8" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="/" class="text-blue-600 hover:text-blue-800 transition duration-200">Beranda</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('berita.publik.index') }}" class="text-blue-600 hover:text-blue-800 transition duration-200">Berita & Pengumuman</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
            </li>
            <li>
                <span class="text-gray-700 truncate max-w-[200px] sm:max-w-none block">{{ \Illuminate\Support\Str::limit($berita->judul, 50) }}</span> {{-- Untuk judul panjang di breadcrumbs --}}
            </li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 p-6 md:p-8">
        {{-- Header Artikel --}}
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">
            {{ $berita->judul }}
        </h1>
        <div class="flex items-center text-gray-600 text-sm mb-6 border-b pb-4">
            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="mr-4">{{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}</span>
            @if ($berita->uploader) {{-- Asumsi ada relasi uploader ke user --}}
                <svg class="w-4 h-4 mr-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                <span>Oleh: {{ $berita->uploader->name ?? 'Admin' }}</span>
            @endif
        </div>

        {{-- Gambar Utama --}}
        @if ($berita->gambar)
            <div class="mb-8 overflow-hidden rounded-lg shadow-md">
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" 
                     class="w-full h-80 object-cover object-center">
            </div>
        @else
            <div class="mb-8 w-full h-80 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg shadow-md border border-gray-200">
                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif

        {{-- Konten Narasi --}}
        <div class="prose prose-blue max-w-none text-gray-800 leading-relaxed text-lg"> {{-- Added prose-blue and text-lg --}}
            {!! $berita->narasi !!}
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-10 pt-6 border-t border-gray-200 text-center">
            <a href="{{ route('berita.publik.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</div>
@endsection