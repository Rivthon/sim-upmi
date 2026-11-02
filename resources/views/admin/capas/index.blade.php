@extends('layouts.admin')
@section('title', 'CAPA')
@section('content')
<div class="mx-auto max-w-7xl">
    <div class="admin-glass rounded-[1.75rem] p-6 md:p-8"><div class="flex flex-col justify-between gap-4 md:flex-row md:items-center"><div><p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Corrective & Preventive Action</p><h2 class="mt-2 text-3xl font-extrabold text-slate-950">CAPA</h2><p class="mt-2 text-slate-600">Kelola akar masalah, tindakan korektif, pencegahan, PIC, deadline, dan verifikasi efektivitas.</p></div><a href="{{ route('admin.capas.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah CAPA</a></div></div>
    @if (session('success')) <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div> @endif
    <div class="mt-6 grid gap-4">
        @forelse ($capas as $capa)
            <div class="admin-glass rounded-2xl p-5"><div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center"><div><p class="text-xs font-bold uppercase tracking-wide text-teal-700">PIC: {{ $capa->pic ?: '-' }} - Deadline: {{ $capa->due_date?->format('d M Y') ?? '-' }}</p><h3 class="mt-1 text-xl font-extrabold text-slate-950">{{ $capa->title }}</h3><p class="mt-1 text-sm text-slate-500">RTM: {{ $capa->managementReview->title ?? '-' }} | AMI: {{ $capa->ami->judul ?? '-' }}</p></div><span class="w-fit rounded-full px-3 py-1 text-xs font-bold {{ $capa->status === 'closed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($capa->status) }}</span><div class="flex gap-2"><a href="{{ route('admin.capas.edit', $capa) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a><form action="{{ route('admin.capas.destroy', $capa) }}" method="POST" onsubmit="return confirm('Hapus CAPA ini?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button></form></div></div></div>
        @empty
            <div class="admin-glass rounded-2xl p-8 text-center text-slate-500">Belum ada CAPA.</div>
        @endforelse
    </div>
</div>
@endsection
