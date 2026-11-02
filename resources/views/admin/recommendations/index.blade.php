@extends('layouts.admin')

@section('title', 'Manajemen Rekomendasi')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">SPMI</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Manajemen Rekomendasi</h2>
                <p class="mt-2 text-slate-600">Kelola rekomendasi lintas AMI, RTM, survey, PPEPP, risiko, monev, dan akreditasi.</p>
            </div>
            <a href="{{ route('admin.recommendations.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah Rekomendasi</a>
        </div>
    </section>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif

    <section class="mt-6 grid gap-5 md:grid-cols-4">
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Total</p><p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $recommendations->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Open</p><p class="mt-2 text-3xl font-extrabold text-red-700">{{ $recommendations->where('status', 'open')->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Proses</p><p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $recommendations->where('status', 'proses')->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Selesai</p><p class="mt-2 text-3xl font-extrabold text-teal-700">{{ $recommendations->where('status', 'selesai')->count() }}</p></div>
    </section>

    <section class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45"><tr><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Rekomendasi</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Sumber</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Prioritas</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">PIC / Deadline</th><th class="px-6 py-4 text-center text-xs font-extrabold uppercase text-slate-500">Aksi</th></tr></thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($recommendations as $recommendation)
                        @php($priorityClass = match ($recommendation->priority) { 'kritis' => 'bg-red-100 text-red-800', 'tinggi' => 'bg-orange-100 text-orange-800', 'sedang' => 'bg-amber-100 text-amber-800', default => 'bg-teal-100 text-teal-800' })
                        <tr class="hover:bg-white/40">
                            <td class="px-6 py-4"><p class="min-w-[260px] font-extrabold text-slate-950">{{ $recommendation->title }}</p><p class="mt-1 text-sm text-slate-500">{{ Str::limit($recommendation->description ?: '-', 90) }}</p></td>
                            <td class="px-6 py-4"><p class="text-sm font-bold uppercase text-slate-700">{{ $recommendation->source }}</p><p class="mt-1 text-xs text-slate-500">{{ $recommendation->unit_name ?: '-' }}</p></td>
                            <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-bold {{ $priorityClass }}">{{ ucfirst($recommendation->priority) }}</span><p class="mt-2 text-xs text-slate-500">{{ ucfirst($recommendation->status) }}</p></td>
                            <td class="px-6 py-4"><p class="text-sm font-bold text-slate-700">{{ $recommendation->pic ?: '-' }}</p><p class="mt-1 text-xs text-slate-500">{{ $recommendation->due_date?->format('d M Y') ?? '-' }}</p></td>
                            <td class="px-6 py-4"><div class="flex justify-center gap-2"><a href="{{ route('admin.recommendations.edit', $recommendation) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a><form action="{{ route('admin.recommendations.destroy', $recommendation) }}" method="POST" onsubmit="return confirm('Hapus rekomendasi ini?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada rekomendasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
