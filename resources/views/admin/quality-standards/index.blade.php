@extends('layouts.admin')

@section('title', 'Standar Mutu')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">SPMI</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Standar Mutu</h2>
                <p class="mt-2 text-slate-600">Kelola standar mutu yang menjadi dasar indikator dan monitoring PPEPP.</p>
            </div>
            <a href="{{ route('admin.quality-standards.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah Standar</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif

    <div class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Kode</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Standar</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Indikator</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-extrabold uppercase text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($standards as $standard)
                        <tr class="hover:bg-white/40">
                            <td class="px-6 py-4 text-sm font-extrabold text-slate-900">{{ $standard->code }}</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-950">{{ $standard->name }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $standard->category ?: '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $standard->indicators_count }}</td>
                            <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-bold {{ $standard->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-600' }}">{{ $standard->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.quality-standards.edit', $standard) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a>
                                    <form action="{{ route('admin.quality-standards.destroy', $standard) }}" method="POST" onsubmit="return confirm('Hapus standar ini?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada standar mutu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
