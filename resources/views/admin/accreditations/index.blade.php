@extends('layouts.admin')

@section('title', 'Akreditasi')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">SPMI</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Akreditasi</h2>
                <p class="mt-2 text-slate-600">Pantau kesiapan dokumen, jadwal asesmen, dan masa berlaku akreditasi prodi/unit.</p>
            </div>
            <a href="{{ route('admin.accreditations.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah Akreditasi</a>
        </div>
    </section>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif

    <section class="mt-6 grid gap-5 md:grid-cols-4">
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Total</p><p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $accreditations->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Aktif Proses</p><p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $accreditations->whereNotIn('status', ['selesai'])->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Selesai</p><p class="mt-2 text-3xl font-extrabold text-teal-700">{{ $accreditations->where('status', 'selesai')->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Rata-rata Progress</p><p class="mt-2 text-3xl font-extrabold text-indigo-700">{{ round($accreditations->avg('document_progress') ?? 0) }}%</p></div>
    </section>

    <section class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45"><tr><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Program</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Peringkat</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Progress</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Tanggal</th><th class="px-6 py-4 text-center text-xs font-extrabold uppercase text-slate-500">Aksi</th></tr></thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($accreditations as $accreditation)
                        <tr class="hover:bg-white/40">
                            <td class="px-6 py-4"><p class="font-extrabold text-slate-950">{{ $accreditation->program_name }}</p><p class="mt-1 text-sm text-slate-500">{{ $accreditation->agency ?: '-' }} / {{ $accreditation->instrument ?: '-' }}</p></td>
                            <td class="px-6 py-4"><p class="text-sm font-bold text-slate-700">{{ $accreditation->current_rank ?: '-' }}</p><p class="mt-1 text-xs text-slate-500">Target: {{ $accreditation->target_rank ?: '-' }}</p></td>
                            <td class="px-6 py-4"><div class="h-2 w-36 rounded-full bg-slate-200"><div class="h-2 rounded-full bg-teal-600" style="width: {{ $accreditation->document_progress }}%"></div></div><p class="mt-2 text-xs font-bold text-slate-600">{{ $accreditation->document_progress }}% / {{ ucfirst($accreditation->status) }}</p></td>
                            <td class="px-6 py-4"><p class="text-sm text-slate-600">Asesmen: {{ $accreditation->assessment_date?->format('d M Y') ?? '-' }}</p><p class="mt-1 text-xs text-slate-500">Berlaku: {{ $accreditation->expiry_date?->format('d M Y') ?? '-' }}</p></td>
                            <td class="px-6 py-4"><div class="flex justify-center gap-2"><a href="{{ route('admin.accreditations.edit', $accreditation) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a><form action="{{ route('admin.accreditations.destroy', $accreditation) }}" method="POST" onsubmit="return confirm('Hapus data akreditasi ini?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada data akreditasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
