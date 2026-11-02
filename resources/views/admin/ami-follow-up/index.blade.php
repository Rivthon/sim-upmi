@extends('layouts.admin')

@section('title', 'Tindak Lanjut Temuan AMI')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">AMI</p>
        <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Tindak Lanjut Temuan AMI</h2>
        <p class="mt-2 text-slate-600">Pantau temuan, rencana perbaikan, target, dan status penyelesaian.</p>
    </div>

    @if (session('success'))
        <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-700">{{ session('success') }}</div>
    @endif

    <div class="admin-glass mt-6 overflow-hidden rounded-[1.5rem]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/70">
                <thead class="bg-white/45">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">AMI</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Temuan</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-extrabold uppercase text-slate-500">Target</th>
                        <th class="px-6 py-4 text-center text-xs font-extrabold uppercase text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/60">
                    @forelse ($items as $item)
                        <tr class="hover:bg-white/40">
                            <td class="px-6 py-4">
                                <p class="font-extrabold text-slate-950">{{ $item->judul }}</p>
                                <p class="text-sm text-slate-500">{{ $item->unit }} - {{ $item->tahun }}</p>
                            </td>
                            <td class="px-6 py-4 max-w-md text-sm text-slate-600">{{ Str::limit($item->hasil_temuan ?: '-', 120) }}</td>
                            <td class="px-6 py-4">
                                @php($status = $item->status_tindak_lanjut ?? 'belum')
                                <span class="rounded-full px-3 py-1 text-xs font-extrabold {{ $status === 'selesai' ? 'bg-green-100 text-green-700' : ($status === 'proses' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $item->target_selesai_tindak_lanjut?->format('d M Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.ami-follow-up.edit', $item) }}" class="rounded-xl bg-white/75 px-4 py-2 text-sm font-bold text-slate-700 ring-1 ring-white hover:bg-white">Kelola</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada temuan AMI yang perlu ditindaklanjuti.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
