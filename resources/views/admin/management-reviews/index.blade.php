@extends('layouts.admin')
@section('title', 'RTM')
@section('content')
<div class="mx-auto max-w-7xl">
    <div class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div><p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Rapat Tinjauan Manajemen</p><h2 class="mt-2 text-3xl font-extrabold text-slate-950">RTM</h2><p class="mt-2 text-slate-600">Kelola agenda, notulen, keputusan, dan tindak lanjut rapat manajemen mutu.</p></div>
            <a href="{{ route('admin.management-reviews.create') }}" class="rounded-2xl bg-slate-950 px-5 py-3 text-center text-sm font-extrabold text-white hover:bg-teal-700">Tambah RTM</a>
        </div>
    </div>
    @if (session('success')) <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div> @endif
    <div class="mt-6 grid gap-4">
        @forelse ($reviews as $review)
            <div class="admin-glass rounded-2xl p-5">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                    <div><p class="text-xs font-bold uppercase tracking-wide text-teal-700">{{ $review->meeting_date?->format('d M Y') }} - {{ $review->location ?: '-' }}</p><h3 class="mt-1 text-xl font-extrabold text-slate-950">{{ $review->title }}</h3><p class="mt-1 text-sm text-slate-500">{{ $review->capas_count }} CAPA terkait</p></div>
                    <span class="w-fit rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">{{ ucfirst($review->status) }}</span>
                    <div class="flex gap-2"><a href="{{ route('admin.management-reviews.edit', $review) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Edit</a><form action="{{ route('admin.management-reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Hapus RTM ini?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Hapus</button></form></div>
                </div>
            </div>
        @empty
            <div class="admin-glass rounded-2xl p-8 text-center text-slate-500">Belum ada RTM.</div>
        @endforelse
    </div>
</div>
@endsection
