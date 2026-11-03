@extends('layouts.admin')

@section('title', 'Manajemen Survey')

@section('content')
<div class="mx-auto max-w-7xl">
    <section class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-5 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Survey</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Survey Kepuasan</h2>
                <p class="mt-2 max-w-2xl text-slate-600">Kelola pertanyaan, periode, link publik, dan hasil survey dalam satu tempat.</p>
            </div>
            <a href="{{ route('admin.survey.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-extrabold text-white hover:bg-teal-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/></svg>
                Buat Survey
            </a>
        </div>
    </section>

    @if (session('success'))<div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>@endif

    <section class="mt-6 grid gap-5 md:grid-cols-4">
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Total Survey</p><p class="mt-2 text-3xl font-extrabold text-slate-950">{{ $surveys->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Sedang Aktif</p><p class="mt-2 text-3xl font-extrabold text-teal-700">{{ $surveys->filter(fn ($item) => $item->isOpenForPublic())->count() }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Pertanyaan</p><p class="mt-2 text-3xl font-extrabold text-indigo-700">{{ $surveys->sum('questions_count') }}</p></div>
        <div class="admin-glass rounded-[1.5rem] p-5"><p class="text-sm font-bold text-slate-500">Total Jawaban</p><p class="mt-2 text-3xl font-extrabold text-amber-600">{{ $surveys->sum('responses_count') }}</p></div>
    </section>

    <section class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45"><tr><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Survey</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Periode</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Status</th><th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Link Publik</th><th class="px-6 py-4 text-center text-xs font-extrabold uppercase text-slate-500">Aksi</th></tr></thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($surveys as $survey)
                        @php
                            $status = $survey->publicStatus();
                            $statusClass = match ($status) { 'aktif' => 'bg-teal-100 text-teal-800', 'terjadwal' => 'bg-blue-100 text-blue-800', 'berakhir' => 'bg-red-100 text-red-800', default => 'bg-slate-200 text-slate-700' };
                            $publicUrl = $survey->public_token ? route('survey.public.show', $survey->public_token) : null;
                        @endphp
                        <tr class="hover:bg-white/40">
                            <td class="px-6 py-4"><p class="min-w-[260px] font-extrabold text-slate-950">{{ $survey->judul }}</p><p class="mt-1 text-sm text-slate-500">{{ $survey->questions_count }} pertanyaan · {{ $survey->responses_count }} jawaban</p></td>
                            <td class="px-6 py-4"><p class="whitespace-nowrap text-sm font-semibold text-slate-700">{{ $survey->starts_at?->format('d M Y H:i') ?? 'Langsung' }}</p><p class="mt-1 whitespace-nowrap text-xs text-slate-500">s.d. {{ $survey->ends_at?->format('d M Y H:i') ?? 'Tanpa batas' }}</p></td>
                            <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">{{ ucfirst($status) }}</span><p class="mt-2 text-xs text-slate-500">{{ $survey->is_public ? 'Publik' : 'Internal' }}</p></td>
                            <td class="px-6 py-4">
                                @if ($survey->is_public && $publicUrl)
                                    <div x-data="{ copied: false }" class="flex min-w-[210px] items-center gap-2">
                                        <input value="{{ $publicUrl }}" readonly class="min-w-0 flex-1 rounded-xl border-white/70 bg-white/70 px-3 py-2 text-xs text-slate-600">
                                        <button type="button" @click="navigator.clipboard.writeText(@js($publicUrl)); copied = true; setTimeout(() => copied = false, 1800)" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-950 text-white hover:bg-teal-700" :title="copied ? 'Tersalin' : 'Salin link'">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V5a2 2 0 012-2h7a2 2 0 012 2v10a2 2 0 01-2 2h-2M5 7h7a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z"/></svg>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-sm text-slate-400">Tidak dibagikan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4"><div class="flex justify-center gap-2"><a href="{{ route('admin.survey.show', $survey) }}" class="rounded-xl bg-white/75 px-3 py-2 text-xs font-bold text-slate-700 ring-1 ring-white hover:bg-white">Kelola</a><a href="{{ route('admin.survey.hasil', $survey) }}" class="rounded-xl bg-teal-50 px-3 py-2 text-xs font-bold text-teal-700 hover:bg-teal-100">Hasil</a><a href="{{ route('admin.survey.edit', $survey) }}" class="rounded-xl bg-amber-50 px-3 py-2 text-xs font-bold text-amber-700 hover:bg-amber-100">Edit</a><form action="{{ route('admin.survey.destroy', $survey) }}" method="POST" onsubmit="return confirm('Hapus survey dan seluruh jawabannya?')">@csrf @method('DELETE')<button class="rounded-xl bg-red-50 px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-100">Hapus</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada survey.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
