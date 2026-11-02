@extends('layouts.admin')

@section('title', 'Laporan Eksekutif')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div>
            <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Executive View</p>
            <h2 class="mt-2 text-3xl font-extrabold text-slate-950 md:text-4xl">Laporan Eksekutif Mutu</h2>
            <p class="mt-2 max-w-3xl text-slate-600">Ringkasan status mutu untuk pimpinan: risiko, monev, akreditasi, rekomendasi, dokumen, PPEPP, dan CAPA.</p>
        </div>
    </section>

    <section class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-5">
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Risiko Tinggi</p><p class="mt-2 text-3xl font-extrabold text-red-700">{{ $riskHigh }}</p><p class="mt-1 text-xs text-slate-500">dari {{ $riskTotal }} risiko</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Monev TL</p><p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $monevNeedFollowUp }}</p><p class="mt-1 text-xs text-slate-500">dari {{ $monevTotal }} monev</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Akreditasi Aktif</p><p class="mt-2 text-3xl font-extrabold text-indigo-700">{{ $accreditationActive }}</p><p class="mt-1 text-xs text-slate-500">dari {{ $accreditationTotal }} data</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Rekomendasi Open</p><p class="mt-2 text-3xl font-extrabold text-red-700">{{ $recommendationOpen }}</p><p class="mt-1 text-xs text-slate-500">open/proses</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Dokumen Pending</p><p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $documentPending }}</p><p class="mt-1 text-xs text-slate-500">approval dokumen</p></div>
    </section>

    <section class="mt-6 grid gap-5 md:grid-cols-2">
        <div class="admin-glass rounded-[1.5rem] p-6">
            <h3 class="text-xl font-extrabold text-slate-950">Top Risiko</h3>
            <div class="mt-5 space-y-3">
                @forelse ($topRisks as $risk)
                    <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-extrabold text-slate-900">{{ $risk->risk_code }}</p>
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-800">{{ $risk->risk_score }} - {{ ucfirst($risk->level) }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600">{{ $risk->title }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $risk->standard?->code ?? '-' }} / {{ $risk->unit_name ?: '-' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada data risiko.</p>
                @endforelse
            </div>
        </div>

        <div class="admin-glass rounded-[1.5rem] p-6">
            <h3 class="text-xl font-extrabold text-slate-950">Rekomendasi Terbuka</h3>
            <div class="mt-5 space-y-3">
                @forelse ($openRecommendations as $recommendation)
                    <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-extrabold text-slate-900">{{ $recommendation->title }}</p>
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">{{ ucfirst($recommendation->priority) }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600">{{ strtoupper($recommendation->source) }} / {{ $recommendation->unit_name ?: '-' }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $recommendation->pic ?: '-' }}{{ $recommendation->due_date ? ' / '.$recommendation->due_date->format('d M Y') : '' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Tidak ada rekomendasi terbuka.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mt-6 grid gap-5 md:grid-cols-3">
        <div class="admin-glass rounded-[1.5rem] p-6">
            <h3 class="text-xl font-extrabold text-slate-950">Monev Terbaru</h3>
            <div class="mt-5 space-y-3">
                @forelse ($recentMonev as $monitoring)
                    <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white">
                        <p class="font-extrabold text-slate-900">{{ $monitoring->unit_name }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ ucfirst($monitoring->achievement_status) }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $monitoring->period }} / {{ $monitoring->indicator?->name ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada monev.</p>
                @endforelse
            </div>
        </div>

        <div class="admin-glass rounded-[1.5rem] p-6">
            <h3 class="text-xl font-extrabold text-slate-950">Akreditasi Mendekat</h3>
            <div class="mt-5 space-y-3">
                @forelse ($upcomingAccreditations as $accreditation)
                    <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white">
                        <p class="font-extrabold text-slate-900">{{ $accreditation->program_name }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $accreditation->document_progress }}% / {{ ucfirst($accreditation->status) }}</p>
                        <p class="mt-1 text-xs text-slate-500">Berlaku sampai {{ $accreditation->expiry_date?->format('d M Y') ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada data masa berlaku akreditasi.</p>
                @endforelse
            </div>
        </div>

        <div class="admin-glass rounded-[1.5rem] p-6">
            <h3 class="text-xl font-extrabold text-slate-950">Pekerjaan Terbuka</h3>
            <div class="mt-5 grid gap-3">
                <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white"><p class="text-sm font-bold text-slate-500">PPEPP Belum Selesai</p><p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $ppeppOpen }}</p></div>
                <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white"><p class="text-sm font-bold text-slate-500">CAPA Open/Proses</p><p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $capaOpen }}</p></div>
                <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white"><p class="text-sm font-bold text-slate-500">Dokumen Pending</p><p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $documentPending }}</p></div>
            </div>
        </div>
    </section>
</div>
@endsection
