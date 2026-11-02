@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<div class="mx-auto max-w-6xl">
    <section class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Website</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950 md:text-4xl">Tambah Berita</h2>
                <p class="mt-2 max-w-2xl leading-7 text-slate-600">Buat artikel atau pengumuman baru untuk halaman publik UPMI.</p>
            </div>
            <a href="{{ route('admin.berita.index') }}" class="rounded-2xl bg-white/75 px-5 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">
                Kembali
            </a>
        </div>
    </section>

    @if ($errors->any())
        <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <p class="font-extrabold">Terjadi kesalahan.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-6 lg:grid-cols-[1.35fr_.65fr]">
        @csrf

        <div class="admin-glass rounded-[1.5rem] p-6">
            <div>
                <label for="judul" class="mb-2 block text-sm font-bold text-slate-700">Judul Berita</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                @error('judul') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-5">
                <label for="narasi" class="mb-2 block text-sm font-bold text-slate-700">Narasi Lengkap</label>
                <textarea id="narasi" name="narasi" rows="14" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500">{{ old('narasi') }}</textarea>
                @error('narasi') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <aside class="admin-glass h-fit rounded-[1.5rem] p-6">
            <h3 class="text-xl font-extrabold text-slate-950">Media & Publikasi</h3>
            <p class="mt-2 text-sm leading-6 text-slate-600">Gunakan gambar yang jelas agar kartu berita di halaman depan terlihat profesional.</p>

            <div class="mt-5 rounded-2xl border border-dashed border-teal-300 bg-white/55 p-5">
                <label for="gambar" class="mb-3 block text-sm font-bold text-slate-700">Gambar Berita</label>
                <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm file:mr-4 file:rounded-full file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-teal-700 hover:file:bg-teal-100">
                <p class="mt-3 text-xs leading-5 text-slate-500">Format gambar JPG, PNG, GIF, atau WebP. Maksimal 5 MB.</p>
                @error('gambar') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 rounded-2xl bg-slate-950 p-5 text-white">
                <p class="text-sm font-bold text-teal-100">Status</p>
                <p class="mt-2 text-lg font-extrabold">Siap dipublikasikan</p>
                <p class="mt-2 text-sm leading-6 text-cyan-50/75">Setelah disimpan, berita akan masuk daftar admin dan dapat tampil di halaman publik.</p>
            </div>

            <div class="mt-6 grid gap-3">
                <button type="submit" class="rounded-2xl bg-teal-600 px-6 py-3 text-sm font-extrabold text-white shadow-lg shadow-teal-700/20 hover:bg-teal-700">
                    Simpan Berita
                </button>
                <a href="{{ route('admin.berita.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">
                    Batal
                </a>
            </div>
        </aside>
    </form>
</div>
@endsection
