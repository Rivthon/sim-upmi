@extends('layouts.admin')

@section('title', 'Indikator Mutu')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">SPMI</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Indikator Mutu</h2>
                <p class="mt-2 text-slate-600">Tetapkan target dan capaian indikator untuk tiap standar mutu.</p>
            </div>
            <a href="{{ route('admin.quality-indicators.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah Indikator</a>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif

    <div class="mt-6 grid gap-4">
        @forelse ($indicators as $indicator)
            <div class="admin-glass rounded-2xl p-5">
                <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-teal-700">{{ $indicator->standard->code ?? '-' }}</p>
                        <h3 class="mt-1 text-xl font-extrabold text-slate-950">{{ $indicator->name }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ $indicator->standard->name ?? '-' }}</p>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div class="rounded-xl bg-white/65 px-4 py-3"><p class="text-xs text-slate-500">Target</p><p class="font-bold">{{ $indicator->target_value ?? '-' }} {{ $indicator->unit }}</p></div>
                        <div class="rounded-xl bg-white/65 px-4 py-3"><p class="text-xs text-slate-500">Capaian</p><p class="font-bold">{{ $indicator->actual_value ?? '-' }} {{ $indicator->unit }}</p></div>
                        <div class="rounded-xl bg-white/65 px-4 py-3"><p class="text-xs text-slate-500">Status</p><p class="font-bold">{{ ucfirst($indicator->status) }}</p></div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.quality-indicators.edit', $indicator) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a>
                        <form action="{{ route('admin.quality-indicators.destroy', $indicator) }}" method="POST" onsubmit="return confirm('Hapus indikator ini?')">
                            @csrf @method('DELETE')
                            <button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="admin-glass rounded-2xl p-8 text-center text-slate-500">Belum ada indikator mutu.</div>
        @endforelse
    </div>
</div>
@endsection
