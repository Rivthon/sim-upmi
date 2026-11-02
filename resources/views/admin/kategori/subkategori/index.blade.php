@extends('layouts.admin')

@section('title', 'Sub Kategori Dokumen')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass overflow-hidden rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Dokumen Mutu</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950 md:text-4xl">Sub Kategori Dokumen</h2>
                <p class="mt-2 max-w-2xl leading-7 text-slate-600">Kelola turunan kategori agar dokumen mutu bisa disusun lebih detail dan mudah difilter.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white/70 px-5 py-3 text-sm font-extrabold text-slate-700 ring-1 ring-white transition hover:bg-white hover:text-teal-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h10"/>
                    </svg>
                    Kategori
                </a>
                <a href="{{ route('admin.subkategori.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-slate-900/20 transition hover:bg-teal-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Sub Kategori
                </a>
            </div>
        </div>
    </section>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <section class="mt-6 grid gap-5 md:grid-cols-4">
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Total Subkategori</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $subkategoris->count() }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Kategori Induk</p>
            <p class="mt-2 text-3xl font-extrabold text-teal-700">{{ $subkategoris->pluck('kategori_dokumen_id')->filter()->unique()->count() }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Dokumen Terkait</p>
            <p class="mt-2 text-3xl font-extrabold text-indigo-700">{{ $subkategoris->sum('dokumen_mutus_count') }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Terbaru</p>
            <p class="mt-2 text-lg font-extrabold text-slate-950">{{ $subkategoris->first()?->created_at?->format('d M Y') ?? '-' }}</p>
        </div>
    </section>

    <section class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Sub Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Kategori Induk</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Dokumen</th>
                        <th class="px-6 py-4 text-center text-xs font-extrabold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($subkategoris as $sub)
                        <tr class="transition hover:bg-white/40">
                            <td class="px-6 py-4">
                                <div class="min-w-[240px]">
                                    <p class="font-extrabold text-slate-950">{{ $sub->nama }}</p>
                                    <p class="mt-1 text-xs font-bold uppercase tracking-wide text-teal-700">Subkategori #{{ $sub->id }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="min-w-[220px]">
                                    <p class="text-sm font-extrabold text-slate-800">{{ $sub->kategori->nama ?? 'Kategori tidak tersedia' }}</p>
                                    <span class="mt-2 inline-flex rounded-full bg-white/70 px-3 py-1 text-xs font-bold text-slate-600 ring-1 ring-white">{{ $sub->kategori->tipe ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-white/70 px-3 py-1 text-xs font-bold text-slate-700 ring-1 ring-white">{{ $sub->dokumen_mutus_count }} dokumen</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.subkategori.edit', $sub->id) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/70 text-slate-700 ring-1 ring-white transition hover:bg-teal-600 hover:text-white" title="Edit subkategori">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.2 5.2l3.6 3.6M4 20h4l11-11a2.5 2.5 0 00-3.5-3.5L4.5 16.5 4 20z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.subkategori.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Hapus subkategori ini? Tindakan ini tidak bisa dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600 ring-1 ring-red-100 transition hover:bg-red-600 hover:text-white" title="Hapus subkategori">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.9 12.1A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5 4v6m4-6v6M9 7V4h6v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-lg font-extrabold text-slate-800">Belum ada subkategori dokumen</p>
                                <p class="mt-2 text-sm text-slate-500">Tambahkan subkategori agar dokumen lebih mudah dikelompokkan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
