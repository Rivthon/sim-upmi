@extends('layouts.admin')

@section('title', 'Edit Kategori Dokumen')

@section('content')
<div class="mx-auto max-w-5xl">
    <section class="admin-glass overflow-hidden rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Dokumen Mutu</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950 md:text-4xl">Edit Kategori</h2>
                <p class="mt-2 max-w-2xl leading-7 text-slate-600">Perbarui nama, tipe akses, dan deskripsi kategori dokumen.</p>
            </div>
            <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white/70 px-5 py-3 text-sm font-extrabold text-slate-700 ring-1 ring-white transition hover:bg-white hover:text-teal-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </section>

    @if ($errors->any())
        <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <p class="font-extrabold">Data belum bisa diperbarui.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="admin-glass mt-6 rounded-[1.5rem] p-6 md:p-8">
        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="nama" class="mb-2 block text-sm font-extrabold text-slate-700">Nama Kategori</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" class="block w-full rounded-2xl border border-white/70 bg-white/75 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-teal-400 focus:ring-4 focus:ring-teal-500/10 @error('nama') border-red-300 @enderror" required>
                    @error('nama') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tipe" class="mb-2 block text-sm font-extrabold text-slate-700">Tipe Akses</label>
                    <select name="tipe" id="tipe" class="block w-full rounded-2xl border border-white/70 bg-white/75 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition focus:border-teal-400 focus:ring-4 focus:ring-teal-500/10 @error('tipe') border-red-300 @enderror" required>
                        <option value="">Pilih tipe akses</option>
                        <option value="Publik" {{ old('tipe', $kategori->tipe) == 'Publik' ? 'selected' : '' }}>Publik</option>
                        <option value="Internal" {{ old('tipe', $kategori->tipe) == 'Internal' ? 'selected' : '' }}>Internal</option>
                    </select>
                    @error('tipe') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="deskripsi" class="mb-2 block text-sm font-extrabold text-slate-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="5" class="block w-full rounded-2xl border border-white/70 bg-white/75 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-teal-400 focus:ring-4 focus:ring-teal-500/10 @error('deskripsi') border-red-300 @enderror">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                @error('deskripsi') <p class="mt-2 text-xs font-bold text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-white/70 pt-6 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-white/70 px-5 py-3 text-sm font-extrabold text-slate-700 ring-1 ring-white transition hover:bg-white">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-slate-900/20 transition hover:bg-teal-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Kategori
                </button>
            </div>
        </form>
    </section>
</div>
@endsection
