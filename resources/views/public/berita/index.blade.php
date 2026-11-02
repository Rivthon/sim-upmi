@extends('layouts.public')

@section('title', 'Berita & Pengumuman - UPMI STIKes Bogor Husada')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-10 text-center">
        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Berita UPMI</p>
        <h2 class="mt-3 text-3xl md:text-5xl font-extrabold text-slate-950">Berita & Pengumuman Terbaru</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($beritas as $berita)
            <div class="glass rounded-[1.5rem] overflow-hidden transition duration-300 hover:-translate-y-1 flex flex-col">
                @if($berita->gambar)
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" 
                         class="w-full h-48 object-cover object-center">
                @else
                    <div class="w-full h-48 bg-white/35 flex items-center justify-center text-slate-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                
                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-extrabold text-slate-950 leading-tight mb-2">
                        <a href="{{ route('berita.publik.show', $berita->slug) }}" class="hover:text-teal-700 transition duration-200">
                            {{ $berita->judul }}
                        </a>
                    </h3>
                    <p class="text-slate-500 text-sm mb-3">
                        <svg class="inline-block w-4 h-4 mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}
                    </p>
                    <p class="text-slate-600 text-base leading-relaxed flex-grow">
                        {{ \Illuminate\Support\Str::limit(strip_tags($berita->narasi), 120) }}
                    </p>
                </div>
                
                <div class="p-6 border-t border-white/60 mt-auto">
                    <a href="{{ route('berita.publik.show', $berita->slug) }}" 
                       class="inline-flex items-center text-teal-700 hover:text-slate-950 font-extrabold transition duration-200">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full glass rounded-[1.5rem] p-8 text-center">
                <p class="text-slate-600 text-lg">Belum ada berita atau pengumuman yang tersedia saat ini.</p>
                <p class="text-slate-500 mt-2">Silakan cek kembali nanti untuk informasi terbaru dari UPMI.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-slate-950 hover:bg-teal-700 text-white font-semibold rounded-full shadow-sm transition duration-300 ease-in-out">
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
