@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Sumber</label>
        <select name="source" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
            @foreach (['ami' => 'AMI', 'rtm' => 'RTM', 'survey' => 'Survey', 'ppepp' => 'PPEPP', 'monev' => 'Monev', 'risiko' => 'Risiko', 'akreditasi' => 'Akreditasi', 'umum' => 'Umum'] as $value => $label)
                <option value="{{ $value }}" @selected(old('source', $recommendation->source) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('source') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Unit / Prodi</label>
        <input type="text" name="unit_name" value="{{ old('unit_name', $recommendation->unit_name) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('unit_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Judul Rekomendasi</label>
    <input type="text" name="title" value="{{ old('title', $recommendation->title) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
    @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5 grid gap-5 md:grid-cols-4">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Prioritas</label>
        <select name="priority" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
            @foreach (['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Tinggi', 'kritis' => 'Kritis'] as $value => $label)
                <option value="{{ $value }}" @selected(old('priority', $recommendation->priority) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('priority') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
            @foreach (['open' => 'Open', 'proses' => 'Proses', 'selesai' => 'Selesai', 'ditunda' => 'Ditunda'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $recommendation->status) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">PIC</label>
        <input type="text" name="pic" value="{{ old('pic', $recommendation->pic) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('pic') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Deadline</label>
        <input type="date" name="due_date" value="{{ old('due_date', optional($recommendation->due_date)->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('due_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Deskripsi</label>
        <textarea name="description" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('description', $recommendation->description) }}</textarea>
        @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Tindak Lanjut</label>
        <textarea name="follow_up" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('follow_up', $recommendation->follow_up) }}</textarea>
        @error('follow_up') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.recommendations.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
