@extends('layouts.public')

@section('title', 'Berita & Pengumuman - UPMI STIKes Bogor Husada')

@section('content')
<div class="container mx-auto px-4 py-8 md:py-12">
    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-8 md:mb-12 text-center">Berita & Pengumuman Terbaru</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($beritas as $berita)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 transition-transform duration-300 hover:scale-[1.02] hover:shadow-xl flex flex-col">
                @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" 
                         class="w-full h-48 object-cover object-center border-b border-gray-200">
                @else
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 border-b border-gray-200">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                
                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-bold text-blue-800 leading-tight mb-2">
                        <a href="{{ route('berita.publik.show', $berita->slug) }}" class="hover:text-blue-600 transition duration-200">
                            {{ $berita->judul }}
                        </a>
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">
                        <svg class="inline-block w-4 h-4 mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}
                    </p>
                    <p class="text-gray-700 text-base leading-relaxed flex-grow">
                        {{ \Illuminate\Support\Str::limit(strip_tags($berita->narasi), 120) }}
                    </p>
                </div>
                
                <div class="p-6 border-t border-gray-100 mt-auto">
                    <a href="{{ route('berita.publik.show', $berita->slug) }}" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition duration-200">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow-lg p-8 text-center border border-gray-200">
                <p class="text-gray-600 text-lg">Belum ada berita atau pengumuman yang tersedia saat ini.</p>
                <p class="text-gray-500 mt-2">Silakan cek kembali nanti untuk informasi terbaru dari UPMI.</p>
                <div class="mt-6">
                    <a href="/" class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Anda bisa menambahkan pagination di sini jika Anda menggunakannya di controller --}}
    {{-- <div class="mt-10">
        {{ $beritas->links() }}
    </div> --}}

</div>
@endsection