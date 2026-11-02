@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass overflow-hidden rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">SIM UPMI</p>
                <h2 class="mt-3 text-3xl font-extrabold text-slate-950 md:text-4xl">Dashboard Penjaminan Mutu</h2>
                <p class="mt-3 max-w-2xl leading-7 text-slate-600">Pantau dokumen mutu, jadwal audit, dan temuan yang perlu ditindaklanjuti dari satu halaman kerja.</p>
            </div>
            <div class="rounded-2xl bg-slate-950 px-5 py-4 text-white">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-cyan-100">Hari ini</p>
                <p class="mt-1 text-lg font-extrabold">{{ now()->format('d F Y') }}</p>
            </div>
        </div>
    </section>

    <section class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-3">
        <div class="admin-glass rounded-[1.5rem] p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-slate-500">Total Dokumen Mutu</p>
                    <p class="mt-3 text-4xl font-extrabold text-slate-950">{{ $totalDokumen }}</p>
                </div>
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-teal-600 p-3 text-white">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>
                </span>
            </div>
            <a href="{{ route('admin.dokumen.index') }}" class="mt-6 inline-flex text-sm font-extrabold text-teal-700 hover:text-slate-950">Kelola dokumen</a>
        </div>

        <div class="admin-glass rounded-[1.5rem] p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-slate-500">Audit Terjadwal</p>
                    <p class="mt-3 text-4xl font-extrabold text-slate-950">{{ $auditTerjadwal }}</p>
                </div>
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 p-3 text-white">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
                    </svg>
                </span>
            </div>
            <a href="{{ route('admin.ami.index') }}" class="mt-6 inline-flex text-sm font-extrabold text-blue-700 hover:text-slate-950">Lihat jadwal AMI</a>
        </div>

        <div class="admin-glass rounded-[1.5rem] p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-slate-500">Temuan Belum Ditindaklanjuti</p>
                    <p class="mt-3 text-4xl font-extrabold text-slate-950">{{ $temuanBelumDitindak }}</p>
                </div>
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500 p-3 text-white">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </span>
            </div>
            <a href="{{ route('admin.ami.index') }}" class="mt-6 inline-flex text-sm font-extrabold text-amber-700 hover:text-slate-950">Tindak lanjuti</a>
        </div>
    </section>

    <section class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-4">
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Dokumen Pending</p>
            <p class="mt-3 text-3xl font-extrabold text-amber-600">{{ $dokumenPending }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Dokumen Approved</p>
            <p class="mt-3 text-3xl font-extrabold text-green-600">{{ $dokumenApproved }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Tindak Lanjut Proses</p>
            <p class="mt-3 text-3xl font-extrabold text-blue-600">{{ $tindakLanjutProses }}</p>
        </div>
        <div class="admin-glass rounded-[1.5rem] p-5">
            <p class="text-sm font-bold text-slate-500">Tindak Lanjut Selesai</p>
            <p class="mt-3 text-3xl font-extrabold text-teal-600">{{ $tindakLanjutSelesai }}</p>
        </div>
    </section>

    <section class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-6">
        <a href="{{ route('admin.quality-standards.index') }}" class="admin-glass rounded-[1.25rem] p-4 hover:bg-white">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Standar</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $totalStandarMutu }}</p>
        </a>
        <a href="{{ route('admin.quality-indicators.index') }}" class="admin-glass rounded-[1.25rem] p-4 hover:bg-white">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Indikator</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $totalIndikatorMutu }}</p>
        </a>
        <a href="{{ route('admin.ppepp-monitorings.index') }}" class="admin-glass rounded-[1.25rem] p-4 hover:bg-white">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">PPEPP</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $totalPpepp }}</p>
        </a>
        <a href="{{ route('admin.management-reviews.index') }}" class="admin-glass rounded-[1.25rem] p-4 hover:bg-white">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">RTM</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $totalRtm }}</p>
        </a>
        <a href="{{ route('admin.capas.index') }}" class="admin-glass rounded-[1.25rem] p-4 hover:bg-white">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">CAPA Open</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $totalCapaOpen }}</p>
        </a>
        <a href="{{ route('admin.quality-calendars.index') }}" class="admin-glass rounded-[1.25rem] p-4 hover:bg-white">
            <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Agenda</p>
            <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $agendaMendatang }}</p>
        </a>
    </section>

    <section class="mt-6 grid gap-5 lg:grid-cols-[1.2fr_.8fr]">
        <div class="admin-glass rounded-[1.5rem] p-6">
            <h3 class="text-xl font-extrabold text-slate-950">Akses Cepat</h3>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('admin.dokumen.create') }}" class="rounded-2xl bg-white/70 p-4 font-bold text-slate-700 ring-1 ring-white/80 hover:bg-white">Upload Dokumen</a>
                <a href="{{ route('admin.ami-follow-up.index') }}" class="rounded-2xl bg-white/70 p-4 font-bold text-slate-700 ring-1 ring-white/80 hover:bg-white">Tindak Lanjut AMI</a>
                <a href="{{ route('admin.pelaporan.create') }}" class="rounded-2xl bg-white/70 p-4 font-bold text-slate-700 ring-1 ring-white/80 hover:bg-white">Tambah Pelaporan</a>
                <a href="{{ route('admin.survey.create') }}" class="rounded-2xl bg-white/70 p-4 font-bold text-slate-700 ring-1 ring-white/80 hover:bg-white">Buat Survey</a>
                <a href="{{ route('admin.activity-log.index') }}" class="rounded-2xl bg-white/70 p-4 font-bold text-slate-700 ring-1 ring-white/80 hover:bg-white">Audit Trail</a>
                <a href="{{ route('admin.backup-restore.index') }}" class="rounded-2xl bg-white/70 p-4 font-bold text-slate-700 ring-1 ring-white/80 hover:bg-white">Backup / Restore</a>
                <a href="{{ route('admin.ppepp-monitorings.create') }}" class="rounded-2xl bg-white/70 p-4 font-bold text-slate-700 ring-1 ring-white/80 hover:bg-white">Tambah PPEPP</a>
                <a href="{{ route('admin.capas.create') }}" class="rounded-2xl bg-white/70 p-4 font-bold text-slate-700 ring-1 ring-white/80 hover:bg-white">Tambah CAPA</a>
            </div>
        </div>

        <div class="rounded-[1.5rem] bg-slate-950 p-6 text-white shadow-2xl shadow-slate-900/20">
            <p class="text-sm font-bold uppercase tracking-[0.18em] text-teal-200">Prioritas</p>
            <h3 class="mt-3 text-2xl font-extrabold">Pastikan dokumen dan temuan selalu terpantau.</h3>
            <p class="mt-4 leading-7 text-cyan-50/75">Gunakan audit trail untuk meninjau aktivitas penting dan menjaga akuntabilitas proses mutu.</p>
        </div>
    </section>
</div>
@endsection
