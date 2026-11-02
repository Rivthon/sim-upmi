@extends('layouts.admin')

@section('title', 'Kelola Tindak Lanjut AMI')

@section('content')
<div class="mx-auto max-w-4xl">
    <form action="{{ route('admin.ami-follow-up.update', $ami) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        @csrf
        @method('PUT')
        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Tindak Lanjut</p>
        <h2 class="mt-2 text-3xl font-extrabold text-slate-950">{{ $ami->judul }}</h2>

        <div class="mt-6 grid gap-5">
            <div>
                <label class="mb-2 block text-sm font-bold text-slate-700">Hasil Temuan</label>
                <textarea name="hasil_temuan" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('hasil_temuan', $ami->hasil_temuan) }}</textarea>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-slate-700">Rencana / Realisasi Tindak Lanjut</label>
                <textarea name="tindak_lanjut" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('tindak_lanjut', $ami->tindak_lanjut) }}</textarea>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
                    <select name="status_tindak_lanjut" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
                        @foreach (['belum' => 'Belum', 'proses' => 'Proses', 'selesai' => 'Selesai'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status_tindak_lanjut', $ami->status_tindak_lanjut ?? 'belum') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-700">Target Selesai</label>
                    <input type="date" name="target_selesai_tindak_lanjut" value="{{ old('target_selesai_tindak_lanjut', $ami->target_selesai_tindak_lanjut?->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
            <a href="{{ route('admin.ami-follow-up.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
        </div>
    </form>
</div>
@endsection
