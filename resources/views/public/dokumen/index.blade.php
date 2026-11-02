@extends('layouts.public')

@section('title', 'Dokumen Publik UPMI STIKes Bogor Husada')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-10 text-center">
        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Dokumen Mutu</p>
        <h2 class="mt-3 text-3xl md:text-5xl font-extrabold text-slate-950">Daftar Dokumen Publik</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($kategoris as $kategori)
            <div class="glass rounded-[1.5rem] p-6 transition duration-300 hover:-translate-y-1 flex flex-col">
                <div class="flex items-center mb-4 pb-3 border-b border-white/70">
                    <svg class="w-8 h-8 mr-3 text-teal-700 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414-.586a1 1 0 011.414 0L9 7.086V5a1 1 0 112 0v2.086l2.172-2.172a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414zM10 12a1 1 0 100 2h4a1 1 0 100-2h-4z" clip-rule="evenodd"></path></svg>
                    <h3 class="text-xl font-extrabold text-slate-950 leading-tight">{{ $kategori->nama }}</h3>
                </div>

                @if($kategori->deskripsi)
                    <p class="text-slate-600 text-sm mb-4 leading-relaxed flex-grow">
                        {{ $kategori->deskripsi }}
                    </p>
                @endif

                @if($kategori->subKategoris->count() > 0)
                    <p class="text-slate-700 font-semibold mb-2 mt-auto">Sub Kategori:</p>
                    <ul class="list-none space-y-2 text-slate-700 text-base">
                        @foreach($kategori->subKategoris as $sub)
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 3a1 1 0 00-1 1v6a1 1 0 102 0V4a1 1 0 00-1-1zm3 4a1 1 0 100 2h3a1 1 0 100-2h-3z"></path></svg>
                                <a href="{{ route('dokumen.publik.show', ['slug' => $sub->slug]) }}" class="text-teal-700 hover:text-slate-950 hover:underline transition duration-200">
                                    {{ $sub->nama }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-slate-500 italic mt-auto">Belum ada sub kategori untuk kategori ini.</p>
                @endif
            </div>
        @empty
            <div class="col-span-full glass rounded-[1.5rem] p-8 text-center">
                <p class="text-slate-600 text-lg">Belum ada kategori dokumen publik yang tersedia saat ini.</p>
                <p class="text-slate-500 mt-2">Silakan cek kembali nanti atau hubungi Admin UPMI untuk informasi lebih lanjut.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
