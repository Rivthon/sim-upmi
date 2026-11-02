@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Standar Mutu</label>
        <select name="quality_standard_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
            <option value="">Pilih Standar</option>
            @foreach ($standards as $standard)
                <option value="{{ $standard->id }}" @selected(old('quality_standard_id', $indicator->quality_standard_id) == $standard->id)>{{ $standard->code }} - {{ $standard->name }}</option>
            @endforeach
        </select>
        @error('quality_standard_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
            @foreach (['belum diukur' => 'Belum Diukur', 'tercapai' => 'Tercapai', 'tidak tercapai' => 'Tidak Tercapai'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $indicator->status ?? 'belum diukur') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Nama Indikator</label>
    <input type="text" name="name" value="{{ old('name', $indicator->name) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5 grid gap-5 md:grid-cols-3">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Satuan</label>
        <input type="text" name="unit" value="{{ old('unit', $indicator->unit) }}" placeholder="%" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Target</label>
        <input type="number" step="0.01" name="target_value" value="{{ old('target_value', $indicator->target_value) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Capaian</label>
        <input type="number" step="0.01" name="actual_value" value="{{ old('actual_value', $indicator->actual_value) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Catatan</label>
    <textarea name="notes" rows="4" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('notes', $indicator->notes) }}</textarea>
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.quality-indicators.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
