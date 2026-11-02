@csrf
<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Judul Agenda</label>
        <input name="title" value="{{ old('title', $calendar->title) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3" required>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Kategori</label>
        <select name="category" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
            @foreach (['umum' => 'Umum', 'ami' => 'AMI', 'survey' => 'Survey', 'rtm' => 'RTM', 'dokumen' => 'Dokumen', 'pelaporan' => 'Pelaporan'] as $value => $label)
                <option value="{{ $value }}" @selected(old('category', $calendar->category ?? 'umum') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-5 grid gap-5 md:grid-cols-3">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Tanggal Mulai</label>
        <input type="date" name="start_date" value="{{ old('start_date', $calendar->start_date?->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3" required>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Tanggal Selesai</label>
        <input type="date" name="end_date" value="{{ old('end_date', $calendar->end_date?->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
            @foreach (['terjadwal' => 'Terjadwal', 'berjalan' => 'Berjalan', 'selesai' => 'Selesai', 'batal' => 'Batal'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $calendar->status ?? 'terjadwal') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Lokasi</label>
    <input name="location" value="{{ old('location', $calendar->location) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
</div>
<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Deskripsi</label>
    <textarea name="description" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">{{ old('description', $calendar->description) }}</textarea>
</div>
<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.quality-calendars.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
