@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Unit / Prodi</label>
        <input type="text" name="unit_name" value="{{ old('unit_name', $monitoring->unit_name) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" placeholder="Prodi Manajemen" required>
        @error('unit_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Periode</label>
        <input type="text" name="period" value="{{ old('period', $monitoring->period) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" placeholder="2026/2027 Ganjil" required>
        @error('period') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Standar Mutu</label>
        <select name="quality_standard_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
            <option value="">Tidak terkait standar</option>
            @foreach ($standards as $standard)
                <option value="{{ $standard->id }}" @selected(old('quality_standard_id', $monitoring->quality_standard_id) == $standard->id)>{{ $standard->code }} - {{ $standard->name }}</option>
            @endforeach
        </select>
        @error('quality_standard_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Indikator Mutu</label>
        <select name="quality_indicator_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
            <option value="">Tidak terkait indikator</option>
            @foreach ($indicators as $indicator)
                <option value="{{ $indicator->id }}" @selected(old('quality_indicator_id', $monitoring->quality_indicator_id) == $indicator->id)>{{ $indicator->standard?->code ?? '-' }} - {{ $indicator->name }}</option>
            @endforeach
        </select>
        @error('quality_indicator_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-4">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Target</label>
        <input type="number" step="0.01" name="target_value" value="{{ old('target_value', $monitoring->target_value) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('target_value') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Realisasi</label>
        <input type="number" step="0.01" name="actual_value" value="{{ old('actual_value', $monitoring->actual_value) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('actual_value') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Status Capaian</label>
        <select name="achievement_status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
            @foreach (['belum diukur' => 'Belum Diukur', 'tercapai' => 'Tercapai', 'tidak tercapai' => 'Tidak Tercapai', 'perlu tindak lanjut' => 'Perlu Tindak Lanjut'] as $value => $label)
                <option value="{{ $value }}" @selected(old('achievement_status', $monitoring->achievement_status) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('achievement_status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Batas Tindak Lanjut</label>
        <input type="date" name="due_date" value="{{ old('due_date', optional($monitoring->due_date)->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('due_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-3">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">PIC</label>
        <input type="text" name="pic" value="{{ old('pic', $monitoring->pic) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('pic') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-bold text-slate-700">Bukti / Link Evidence</label>
        <input type="text" name="evidence" value="{{ old('evidence', $monitoring->evidence) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('evidence') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Analisis</label>
    <textarea name="analysis" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('analysis', $monitoring->analysis) }}</textarea>
    @error('analysis') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.unit-monitorings.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
