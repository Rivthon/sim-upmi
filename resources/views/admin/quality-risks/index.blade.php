@extends('layouts.admin')

@section('title', 'Manajemen Risiko Mutu')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">SPMI</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Manajemen Risiko Mutu</h2>
                <p class="mt-2 text-slate-600">Pantau risiko mutu berdasarkan standar, unit, skor, mitigasi, dan PIC.</p>
            </div>
            <a href="{{ route('admin.quality-risks.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah Risiko</a>
        </div>
    </section>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif

    <section class="mt-6 grid gap-5 md:grid-cols-4">
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Total Risiko</p><p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $risks->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Risiko Tinggi</p><p class="mt-2 text-3xl font-extrabold text-red-700">{{ $risks->whereIn('level', ['tinggi', 'ekstrem'])->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Mitigasi</p><p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $risks->where('status', 'mitigasi')->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Closed</p><p class="mt-2 text-3xl font-extrabold text-teal-700">{{ $risks->where('status', 'closed')->count() }}</p></div>
    </section>

    <section class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Risiko</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Standar / Unit</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Skor</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-extrabold uppercase text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($risks as $risk)
                        @php($levelClass = match ($risk->level) { 'ekstrem' => 'bg-red-100 text-red-800', 'tinggi' => 'bg-orange-100 text-orange-800', 'sedang' => 'bg-amber-100 text-amber-800', default => 'bg-teal-100 text-teal-800' })
                        <tr class="hover:bg-white/40">
                            <td class="px-6 py-4"><p class="font-extrabold text-slate-950">{{ $risk->risk_code }}</p><p class="mt-1 min-w-[240px] text-sm text-slate-600">{{ $risk->title }}</p></td>
                            <td class="px-6 py-4"><p class="min-w-[220px] text-sm font-bold text-slate-700">{{ $risk->standard?->code ?? '-' }}</p><p class="mt-1 text-sm text-slate-500">{{ $risk->unit_name ?: '-' }}</p></td>
                            <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-bold {{ $levelClass }}">{{ $risk->risk_score }} - {{ ucfirst($risk->level) }}</span></td>
                            <td class="px-6 py-4"><p class="text-sm font-bold text-slate-700">{{ ucfirst($risk->status) }}</p><p class="mt-1 text-xs text-slate-500">{{ $risk->pic ?: '-' }}{{ $risk->due_date ? ' / '.$risk->due_date->format('d M Y') : '' }}</p></td>
                            <td class="px-6 py-4"><div class="flex justify-center gap-2"><a href="{{ route('admin.quality-risks.edit', $risk) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a><form action="{{ route('admin.quality-risks.destroy', $risk) }}" method="POST" onsubmit="return confirm('Hapus risiko ini?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada risiko mutu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
