@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Standar</label>
        <select name="quality_standard_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
            <option value="">Opsional</option>
            @foreach ($standards as $standard)
                <option value="{{ $standard->id }}" @selected(old('quality_standard_id', $monitoring->quality_standard_id) == $standard->id)>{{ $standard->code }} - {{ $standard->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Indikator</label>
        <select name="quality_indicator_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
            <option value="">Opsional</option>
            @foreach ($indicators as $indicator)
                <option value="{{ $indicator->id }}" @selected(old('quality_indicator_id', $monitoring->quality_indicator_id) == $indicator->id)>{{ $indicator->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-4">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Siklus</label>
        <select name="cycle" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3" required>
            @foreach (['Penetapan', 'Pelaksanaan', 'Evaluasi', 'Pengendalian', 'Peningkatan'] as $cycle)
                <option value="{{ $cycle }}" @selected(old('cycle', $monitoring->cycle) === $cycle)>{{ $cycle }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Periode</label>
        <input type="text" name="period" value="{{ old('period', $monitoring->period) }}" placeholder="2026/2027" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
            @foreach (['draft' => 'Draft', 'proses' => 'Proses', 'selesai' => 'Selesai', 'terlambat' => 'Terlambat'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $monitoring->status ?? 'draft') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Deadline</label>
        <input type="date" name="due_date" value="{{ old('due_date', $monitoring->due_date?->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Penanggung Jawab</label>
    <select name="owner_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
        <option value="">Opsional</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected(old('owner_id', $monitoring->owner_id) == $user->id)>{{ $user->name }}</option>
        @endforeach
    </select>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Ringkasan</label>
        <textarea name="summary" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">{{ old('summary', $monitoring->summary) }}</textarea>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Bukti / Link Evidence</label>
        <textarea name="evidence" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">{{ old('evidence', $monitoring->evidence) }}</textarea>
    </div>
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.ppepp-monitorings.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
