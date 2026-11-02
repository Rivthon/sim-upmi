@extends('layouts.admin')

@section('title', 'Manajemen Dokumen Mutu')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass overflow-hidden rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Dokumen Mutu</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950 md:text-4xl">Manajemen Dokumen Mutu</h2>
                <p class="mt-2 max-w-2xl leading-7 text-slate-600">Kelola dokumen mutu, versi, revisi, publikasi, dan approval sebelum dokumen tampil ke publik.</p>
            </div>
            <a href="{{ route('admin.dokumen.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-slate-900/20 transition hover:bg-teal-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/>
                </svg>
                Upload Dokumen
            </a>
        </div>
    </section>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <section class="mt-6 grid gap-5 md:grid-cols-4">
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Total Dokumen</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $dokumens->count() }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Approved</p>
            <p class="mt-2 text-3xl font-extrabold text-green-700">{{ $dokumens->where('approval_status', 'approved')->count() }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Pending</p>
            <p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $dokumens->where('approval_status', 'pending')->count() }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Publik</p>
            <p class="mt-2 text-3xl font-extrabold text-teal-700">{{ $dokumens->where('tipe', 'Publik')->count() }}</p>
        </div>
    </section>

    <section class="admin-glass mt-6 overflow-visible rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Dokumen</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Versi</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Approval</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">Revisi</th>
                        <th class="px-6 py-4 text-center text-xs font-extrabold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($dokumens as $dokumen)
                        @php
                            $approvalClass = match ($dokumen->approval_status ?? 'pending') {
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                default => 'bg-amber-100 text-amber-800',
                            };
                            $statusClass = match ($dokumen->status) {
                                'Aktif' => 'bg-teal-100 text-teal-800',
                                'Revisi' => 'bg-blue-100 text-blue-800',
                                default => 'bg-slate-200 text-slate-700',
                            };
                        @endphp
                        <tr class="transition hover:bg-white/40">
                            <td class="px-6 py-4">
                                <div class="min-w-[260px]">
                                    <a href="{{ route('admin.dokumen.show', $dokumen) }}" class="font-extrabold text-slate-950 hover:text-teal-700">
                                        {{ $dokumen->judul }}
                                    </a>
                                    <p class="mt-1 text-xs font-bold uppercase tracking-wide text-teal-700">{{ $dokumen->kode_dokumen }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $dokumen->tanggal_terbit?->format('d M Y') ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="whitespace-nowrap text-sm font-bold text-slate-700">{{ $dokumen->kategori->nama ?? '-' }}</p>
                                <p class="mt-1 whitespace-nowrap text-sm text-slate-500">{{ $dokumen->subKategori->nama ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-700">{{ $dokumen->versi }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-2">
                                    <span class="w-fit rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">{{ $dokumen->status }}</span>
                                    <span class="w-fit rounded-full bg-white/70 px-3 py-1 text-xs font-bold text-slate-600 ring-1 ring-white">{{ $dokumen->tipe }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $approvalClass }}">{{ ucfirst($dokumen->approval_status ?? 'pending') }}</span>
                                @if ($dokumen->approver)
                                    <p class="mt-2 text-xs text-slate-500">{{ $dokumen->approver->name }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($dokumen->revisiDari)
                                    <a href="{{ route('admin.dokumen.show', $dokumen->revisiDari) }}" class="font-bold text-teal-700 hover:text-slate-950">
                                        {{ $dokumen->revisiDari->kode_dokumen }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div x-data="{ open: false }" class="relative flex justify-center" @click.away="open = false">
                                    <button type="button" @click="open = !open" class="inline-flex items-center gap-2 rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white transition hover:bg-white">
                                        Aksi
                                        <svg class="h-4 w-4 transition" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-cloak x-transition class="absolute right-0 top-11 z-20 w-48 rounded-2xl border border-white/80 bg-white p-2 text-left shadow-2xl shadow-slate-900/15">
                                        <a href="{{ route('admin.dokumen.show', $dokumen) }}" class="block rounded-xl px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('admin.dokumen.edit', $dokumen) }}" class="block rounded-xl px-4 py-2 text-sm font-bold text-slate-700 hover:bg-slate-50">Edit</a>
                                        <a href="{{ route('admin.dokumen.create', ['revisi' => $dokumen->id]) }}" class="block rounded-xl px-4 py-2 text-sm font-bold text-orange-600 hover:bg-orange-50">Buat Revisi</a>
                                        <form action="{{ route('admin.dokumen.destroy', $dokumen) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full rounded-xl px-4 py-2 text-left text-sm font-bold text-red-600 hover:bg-red-50">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="mx-auto max-w-md">
                                    <p class="text-lg font-extrabold text-slate-800">Belum ada dokumen mutu.</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-500">Mulai unggah dokumen standar, manual, formulir, atau arsip mutu.</p>
                                    <a href="{{ route('admin.dokumen.create') }}" class="mt-5 inline-flex rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Upload Dokumen</a>
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
