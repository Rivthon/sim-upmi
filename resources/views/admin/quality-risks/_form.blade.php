@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Kode Risiko</label>
        <input type="text" name="risk_code" value="{{ old('risk_code', $risk->risk_code) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" placeholder="RSK-001" required>
        @error('risk_code') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Unit / Prodi</label>
        <input type="text" name="unit_name" value="{{ old('unit_name', $risk->unit_name) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" placeholder="UPMI / Prodi Manajemen">
        @error('unit_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Standar Mutu</label>
        <select name="quality_standard_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
            <option value="">Tidak terkait standar</option>
            @foreach ($standards as $standard)
                <option value="{{ $standard->id }}" @selected(old('quality_standard_id', $risk->quality_standard_id) == $standard->id)>{{ $standard->code }} - {{ $standard->name }}</option>
            @endforeach
        </select>
        @error('quality_standard_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
            @foreach (['open' => 'Open', 'mitigasi' => 'Mitigasi', 'terkendali' => 'Terkendali', 'closed' => 'Closed'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $risk->status) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Judul Risiko</label>
    <input type="text" name="title" value="{{ old('title', $risk->title) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
    @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5 grid gap-5 md:grid-cols-3">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Likelihood 1-5</label>
        <input type="number" name="likelihood" min="1" max="5" value="{{ old('likelihood', $risk->likelihood ?? 1) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
        @error('likelihood') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Impact 1-5</label>
        <input type="number" name="impact" min="1" max="5" value="{{ old('impact', $risk->impact ?? 1) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
        @error('impact') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">PIC</label>
        <input type="text" name="pic" value="{{ old('pic', $risk->pic) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('pic') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Deskripsi Risiko</label>
        <textarea name="description" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('description', $risk->description) }}</textarea>
        @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Mitigasi</label>
        <textarea name="mitigation" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('mitigation', $risk->mitigation) }}</textarea>
        @error('mitigation') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Batas Tindak Lanjut</label>
    <input type="date" name="due_date" value="{{ old('due_date', optional($risk->due_date)->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
    @error('due_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.quality-risks.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
