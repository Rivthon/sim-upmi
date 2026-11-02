@extends('layouts.admin')

@section('title', 'Backup / Restore')

@section('content')
<div class="mx-auto max-w-6xl">
    <div class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Database Admin</p>
        <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Backup / Restore</h2>
        <p class="mt-2 text-slate-600">Buat salinan database dan restore file SQL saat dibutuhkan.</p>
    </div>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 font-semibold text-red-700">{{ $errors->first() }}</div>
    @endif

    <div class="mt-6 grid gap-5 lg:grid-cols-2">
        <form action="{{ route('admin.backup-restore.backup') }}" method="POST" class="admin-glass rounded-[1.5rem] p-6">
            @csrf
            <h3 class="text-xl font-extrabold text-slate-950">Buat Backup Baru</h3>
            <p class="mt-2 text-sm leading-6 text-slate-600">File SQL akan disimpan di storage internal project dan bisa diunduh dari daftar backup.</p>
            <button type="submit" class="mt-5 rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Generate Backup</button>
        </form>

        <form action="{{ route('admin.backup-restore.restore') }}" method="POST" enctype="multipart/form-data" class="admin-glass rounded-[1.5rem] p-6" onsubmit="return confirm('Restore akan menimpa data database saat ini. Lanjutkan?')">
            @csrf
            <h3 class="text-xl font-extrabold text-slate-950">Restore Database</h3>
            <p class="mt-2 text-sm leading-6 text-slate-600">Upload file SQL yang valid. Sebaiknya buat backup baru sebelum restore.</p>
            <input type="file" name="backup_file" accept=".sql,.txt" required class="mt-5 w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm">
            <button type="submit" class="mt-5 rounded-2xl bg-red-600 px-6 py-3 text-sm font-extrabold text-white hover:bg-red-700">Restore</button>
        </form>
    </div>

    <div class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="border-b border-white/60 px-6 py-4">
            <h3 class="text-xl font-extrabold text-slate-950">Daftar Backup</h3>
        </div>
        <div class="divide-y divide-white/60">
            @forelse ($backups as $backup)
                <div class="flex flex-col justify-between gap-3 px-6 py-4 sm:flex-row sm:items-center">
                    <div>
                        <p class="font-bold text-slate-900">{{ basename($backup) }}</p>
                        <p class="text-sm text-slate-500">{{ $backup }}</p>
                    </div>
                    <a href="{{ route('admin.backup-restore.download', basename($backup)) }}" class="rounded-xl bg-white/75 px-4 py-2 text-center text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Download</a>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-slate-500">Belum ada file backup.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
