@extends('layouts.public')

@section('title', 'Terima Kasih')

@section('content')
<div class="mx-auto max-w-2xl">
    <section class="glass rounded-[1.75rem] p-8 text-center md:p-12">
        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-teal-100 text-teal-700">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </span>
        <p class="mt-5 text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Jawaban Tersimpan</p>
        <h1 class="mt-3 text-3xl font-extrabold text-slate-950">Terima kasih</h1>
        <p class="mt-4 leading-7 text-slate-600">Jawaban Anda untuk “{{ $survey->judul }}” sudah diterima dan akan digunakan untuk peningkatan mutu layanan.</p>
        <a href="{{ route('home') }}" class="mt-7 inline-flex rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Kembali ke Beranda</a>
    </section>
</div>
@endsection
