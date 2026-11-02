@extends('layouts.admin')

@section('title', 'Monev Prodi / Unit')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">SPMI</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Monev Prodi / Unit</h2>
                <p class="mt-2 text-slate-600">Monitoring capaian mutu per prodi, biro, fakultas, atau unit kerja.</p>
            </div>
            <a href="{{ route('admin.unit-monitorings.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah Monev</a>
        </div>
    </section>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif

    <section class="mt-6 grid gap-5 md:grid-cols-4">
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Total Monev</p><p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $monitorings->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Tercapai</p><p class="mt-2 text-3xl font-extrabold text-teal-700">{{ $monitorings->where('achievement_status', 'tercapai')->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Belum Tercapai</p><p class="mt-2 text-3xl font-extrabold text-red-700">{{ $monitorings->where('achievement_status', 'tidak tercapai')->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Tindak Lanjut</p><p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $monitorings->where('achievement_status', 'perlu tindak lanjut')->count() }}</p></div>
    </section>

    <section class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45"><tr><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Unit</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Standar / Indikator</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Capaian</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">PIC</th><th class="px-6 py-4 text-center text-xs font-extrabold uppercase text-slate-500">Aksi</th></tr></thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($monitorings as $monitoring)
                        @php($statusClass = match ($monitoring->achievement_status) { 'tercapai' => 'bg-teal-100 text-teal-800', 'tidak tercapai' => 'bg-red-100 text-red-800', 'perlu tindak lanjut' => 'bg-amber-100 text-amber-800', default => 'bg-slate-200 text-slate-700' })
                        <tr class="hover:bg-white/40">
                            <td class="px-6 py-4"><p class="font-extrabold text-slate-950">{{ $monitoring->unit_name }}</p><p class="mt-1 text-sm text-slate-500">{{ $monitoring->period }}</p></td>
                            <td class="px-6 py-4"><p class="min-w-[250px] text-sm font-bold text-slate-700">{{ $monitoring->standard?->code ?? '-' }}</p><p class="mt-1 text-sm text-slate-500">{{ $monitoring->indicator?->name ?? '-' }}</p></td>
                            <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">{{ ucfirst($monitoring->achievement_status) }}</span><p class="mt-2 text-xs text-slate-500">Target {{ $monitoring->target_value ?? '-' }} / Realisasi {{ $monitoring->actual_value ?? '-' }}</p></td>
                            <td class="px-6 py-4"><p class="text-sm font-bold text-slate-700">{{ $monitoring->pic ?: '-' }}</p><p class="mt-1 text-xs text-slate-500">{{ $monitoring->due_date?->format('d M Y') ?? '-' }}</p></td>
                            <td class="px-6 py-4"><div class="flex justify-center gap-2"><a href="{{ route('admin.unit-monitorings.edit', $monitoring) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a><form action="{{ route('admin.unit-monitorings.destroy', $monitoring) }}" method="POST" onsubmit="return confirm('Hapus data monev ini?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada data monev prodi/unit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
