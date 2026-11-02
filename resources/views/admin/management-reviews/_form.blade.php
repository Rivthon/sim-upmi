@csrf
<div class="grid gap-5 md:grid-cols-3">
    <div class="md:col-span-2">
        <label class="mb-2 block text-sm font-bold text-slate-700">Judul RTM</label>
        <input name="title" value="{{ old('title', $review->title) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3" required>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Tanggal</label>
        <input type="date" name="meeting_date" value="{{ old('meeting_date', $review->meeting_date?->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3" required>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Lokasi</label>
        <input name="location" value="{{ old('location', $review->location) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">
            @foreach (['draft' => 'Draft', 'selesai' => 'Selesai', 'ditindaklanjuti' => 'Ditindaklanjuti'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $review->status ?? 'draft') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
@foreach (['agenda' => 'Agenda', 'participants' => 'Peserta', 'notes' => 'Notulen', 'decisions' => 'Keputusan'] as $field => $label)
    <div class="mt-5">
        <label class="mb-2 block text-sm font-bold text-slate-700">{{ $label }}</label>
        <textarea name="{{ $field }}" rows="4" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">{{ old($field, $review->{$field}) }}</textarea>
    </div>
@endforeach
<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.management-reviews.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
