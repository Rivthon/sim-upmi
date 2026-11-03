@extends('layouts.public')

@section('title', 'Survey Tidak Tersedia')

@section('content')
<div class="mx-auto max-w-2xl">
    <section class="glass rounded-[1.75rem] p-8 text-center md:p-12">
        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-100 text-red-700">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.1 19h13.8a2 2 0 001.7-3L13.7 4a2 2 0 00-3.4 0L3.4 16a2 2 0 001.7 3z"/></svg>
        </span>
        <p class="mt-5 text-sm font-extrabold uppercase tracking-[0.2em] text-red-700">Survey Ditutup</p>
        <h1 class="mt-3 text-3xl font-extrabold text-slate-950">{{ $survey->judul }}</h1>
        <p class="mt-4 leading-7 text-slate-600">
            @if ($survey->starts_at && now()->lt($survey->starts_at))
                Survey belum dibuka. Pengisian dimulai {{ $survey->starts_at->format('d M Y H:i') }} WIB.
            @elseif ($survey->ends_at && now()->gt($survey->ends_at))
                Masa pengisian telah berakhir pada {{ $survey->ends_at->format('d M Y H:i') }} WIB.
            @else
                Survey sedang tidak aktif atau akses publik telah dinonaktifkan oleh admin.
            @endif
        </p>
        <a href="{{ route('home') }}" class="mt-7 inline-flex rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Kembali ke Beranda</a>
    </section>
</div>
@endsection
