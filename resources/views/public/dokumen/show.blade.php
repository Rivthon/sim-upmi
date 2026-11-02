@extends('layouts.public')

@section('title', 'Dokumen: ' . $subkategori->nama . ' - UPMI STIKes Bogor Husada')

@section('content')
<div class="mx-auto max-w-7xl">
    {{-- Breadcrumbs --}}
    <nav class="glass rounded-2xl px-5 py-4 text-sm font-medium text-slate-500 mb-6 md:mb-8" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('home') }}" class="text-teal-700 hover:text-slate-950 transition duration-200">Beranda</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('dokumen.publik.index') }}" class="text-teal-700 hover:text-slate-950 transition duration-200">Dokumen Publik</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
            </li>
            <li>
                <span class="text-gray-700">{{ $subkategori->nama }}</span>
            </li>
        </ol>
    </nav>

    <div class="glass mx-auto rounded-[1.75rem] overflow-hidden">
        <div class="p-6 md:p-8 border-b border-white/70">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-950 mb-2">Dokumen: {{ $subkategori->nama }}</h2>
            <p class="text-slate-600 text-lg">{{ $subkategori->kategori->nama ?? 'Kategori Tidak Diketahui' }}</p>
        </div>

        @if($dokumens->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/70">
                    <thead class="bg-white/45">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun Terbit</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Versi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">File</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/60">
                        @foreach($dokumens as $index => $dok)
                            <tr class="hover:bg-white/45 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800 max-w-xs truncate">{{ $dok->judul }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $dok->kode_dokumen ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($dok->tanggal_terbit)->format('Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $dok->versi ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $dok->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('dokumen.publik.download', $dok->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-full text-sm transition duration-200 ease-in-out">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Unduh
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-white/70 bg-white/30 text-center">
                <a href="{{ route('dokumen.publik.index') }}" class="inline-flex items-center px-6 py-3 bg-slate-950 hover:bg-teal-700 text-white font-semibold rounded-full shadow-sm transition duration-300 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Kategori
                </a>
            </div>
        @else
            <div class="p-6 md:p-8 text-center bg-white/30">
                <p class="text-slate-600 text-lg">Belum ada dokumen publik yang tersedia di subkategori <span class="font-semibold">{{ $subkategori->nama }}</span> ini.</p>
                <p class="text-slate-500 mt-2">Silakan cek kembali nanti atau hubungi Admin UPMI untuk informasi lebih lanjut.</p>
                <div class="mt-6">
                    <a href="{{ route('dokumen.publik.index') }}" class="inline-flex items-center px-6 py-3 bg-slate-950 hover:bg-teal-700 text-white font-semibold rounded-full shadow-sm transition duration-300 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Kategori
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
