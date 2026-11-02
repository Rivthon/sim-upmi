@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
<div class="mx-auto max-w-5xl">
    <div class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Pusat Informasi</p>
        <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Notifikasi</h2>
        <p class="mt-2 text-slate-600">Aktivitas penting seperti approval, tindak lanjut AMI, backup, dan restore akan tampil di sini.</p>
    </div>

    <div class="mt-6 space-y-3">
        @forelse ($notifications as $notification)
            <a href="{{ $notification->url ?: '#' }}" class="admin-glass block rounded-2xl p-5 hover:bg-white">
                <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                    <div>
                        <p class="font-extrabold text-slate-950">{{ $notification->title }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ $notification->message }}</p>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </a>
        @empty
            <div class="admin-glass rounded-2xl p-8 text-center text-slate-500">Belum ada notifikasi.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $notifications->links() }}</div>
</div>
@endsection
