@extends('layouts.admin')

@section('title', 'Monitoring PPEPP')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">PPEPP</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Monitoring PPEPP</h2>
                <p class="mt-2 text-slate-600">Pantau Penetapan, Pelaksanaan, Evaluasi, Pengendalian, dan Peningkatan standar mutu.</p>
            </div>
            <a href="{{ route('admin.ppepp-monitorings.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah Monitoring</a>
        </div>
    </div>
    @if (session('success')) <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div> @endif
    <div class="mt-6 grid gap-4">
        @forelse ($items as $item)
            <div class="admin-glass rounded-2xl p-5">
                <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-teal-700">{{ $item->cycle }} - {{ $item->period ?: '-' }}</p>
                        <h3 class="mt-1 text-xl font-extrabold text-slate-950">{{ $item->standard->name ?? 'Tanpa standar' }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ $item->indicator->name ?? 'Tanpa indikator' }}</p>
                    </div>
                    <div class="text-sm text-slate-600">PJ: {{ $item->owner->name ?? '-' }}<br>Deadline: {{ $item->due_date?->format('d M Y') ?? '-' }}</div>
                    <span class="w-fit rounded-full px-3 py-1 text-xs font-extrabold {{ $item->status === 'selesai' ? 'bg-green-100 text-green-700' : ($item->status === 'terlambat' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">{{ ucfirst($item->status) }}</span>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.ppepp-monitorings.edit', $item) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a>
                        <form action="{{ route('admin.ppepp-monitorings.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus monitoring ini?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button></form>
                    </div>
                </div>
            </div>
        @empty
            <div class="admin-glass rounded-2xl p-8 text-center text-slate-500">Belum ada monitoring PPEPP.</div>
        @endforelse
    </div>
</div>
@endsection
