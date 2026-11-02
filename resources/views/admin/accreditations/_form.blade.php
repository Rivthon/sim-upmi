@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Program Studi / Unit</label>
        <input type="text" name="program_name" value="{{ old('program_name', $accreditation->program_name) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
        @error('program_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Lembaga Akreditasi</label>
        <input type="text" name="agency" value="{{ old('agency', $accreditation->agency) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" placeholder="BAN-PT / LAM">
        @error('agency') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-3">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Instrumen</label>
        <input type="text" name="instrument" value="{{ old('instrument', $accreditation->instrument) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('instrument') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Peringkat Saat Ini</label>
        <input type="text" name="current_rank" value="{{ old('current_rank', $accreditation->current_rank) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('current_rank') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Target Peringkat</label>
        <input type="text" name="target_rank" value="{{ old('target_rank', $accreditation->target_rank) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('target_rank') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-4">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Tanggal Submit</label>
        <input type="date" name="submission_date" value="{{ old('submission_date', optional($accreditation->submission_date)->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('submission_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Tanggal Asesmen</label>
        <input type="date" name="assessment_date" value="{{ old('assessment_date', optional($accreditation->assessment_date)->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('assessment_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Masa Berlaku</label>
        <input type="date" name="expiry_date" value="{{ old('expiry_date', optional($accreditation->expiry_date)->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('expiry_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Progress Dokumen (%)</label>
        <input type="number" name="document_progress" min="0" max="100" value="{{ old('document_progress', $accreditation->document_progress ?? 0) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
        @error('document_progress') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">PIC</label>
        <input type="text" name="pic" value="{{ old('pic', $accreditation->pic) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('pic') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Status</label>
        <select name="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
            @foreach (['persiapan' => 'Persiapan', 'submit' => 'Submit', 'asesmen' => 'Asesmen', 'menunggu hasil' => 'Menunggu Hasil', 'selesai' => 'Selesai'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $accreditation->status) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Catatan</label>
    <textarea name="notes" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('notes', $accreditation->notes) }}</textarea>
    @error('notes') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.accreditations.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
