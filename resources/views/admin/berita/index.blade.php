@extends('layouts.admin')

@section('title', 'Daftar Berita')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass overflow-hidden rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Website</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950 md:text-4xl">Berita & Pengumuman</h2>
                <p class="mt-2 max-w-2xl leading-7 text-slate-600">Kelola publikasi berita, informasi kegiatan, dan pengumuman yang tampil di halaman depan.</p>
            </div>
            <a href="{{ route('admin.berita.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-slate-900/20 transition hover:bg-teal-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/>
                </svg>
                Tambah Berita
            </a>
        </div>
    </section>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <section class="mt-6 grid gap-5 md:grid-cols-3">
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Total Berita</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $beritas->count() }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Dengan Gambar</p>
            <p class="mt-2 text-3xl font-extrabold text-teal-700">{{ $beritas->whereNotNull('gambar')->count() }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Terbaru</p>
            <p class="mt-2 text-lg font-extrabold text-slate-950">{{ $beritas->first()?->created_at?->format('d M Y') ?? '-' }}</p>
        </div>
    </section>

    <section class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Berita</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Ringkasan</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-center text-xs font-extrabold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($beritas as $berita)
                        <tr class="transition hover:bg-white/40">
                            <td class="px-6 py-4">
                                <div class="flex min-w-[280px] items-center gap-4">
                                    @if ($berita->gambar)
                                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="h-16 w-20 rounded-2xl object-cover shadow-sm ring-1 ring-white/80">
                                    @else
                                        <span class="flex h-16 w-20 items-center justify-center rounded-2xl bg-white/60 text-slate-400 ring-1 ring-white/80">
                                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4-4a2 2 0 012.8 0l1.2 1.2 2-2a2 2 0 012.8 0L20 14M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                                            </svg>
                                        </span>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="truncate text-base font-extrabold text-slate-950">{{ $berita->judul }}</p>
                                        <p class="mt-1 truncate text-xs font-bold uppercase tracking-wide text-teal-700">{{ $berita->slug ?? 'artikel' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="max-w-md text-sm leading-6 text-slate-600">{{ Str::limit(strip_tags($berita->narasi), 120) }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-600">
                                {{ $berita->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.berita.edit', $berita) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a>
                                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="mx-auto max-w-md">
                                    <p class="text-lg font-extrabold text-slate-800">Belum ada berita.</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-500">Mulai tambahkan berita atau pengumuman untuk ditampilkan di halaman publik.</p>
                                    <a href="{{ route('admin.berita.create') }}" class="mt-5 inline-flex rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Tambah Berita</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
