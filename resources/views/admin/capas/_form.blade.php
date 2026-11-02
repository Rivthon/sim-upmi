@csrf
<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">RTM Terkait</label>
        <select name="management_review_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3"><option value="">Opsional</option>@foreach ($reviews as $review)<option value="{{ $review->id }}" @selected(old('management_review_id', $capa->management_review_id) == $review->id)>{{ $review->title }}</option>@endforeach</select>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">AMI Terkait</label>
        <select name="jadwal_ami_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3"><option value="">Opsional</option>@foreach ($amis as $ami)<option value="{{ $ami->id }}" @selected(old('jadwal_ami_id', $capa->jadwal_ami_id) == $ami->id)>{{ $ami->judul }}</option>@endforeach</select>
    </div>
</div>
<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Judul CAPA</label>
    <input name="title" value="{{ old('title', $capa->title) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3" required>
</div>
<div class="mt-5 grid gap-5 md:grid-cols-3">
    <div><label class="mb-2 block text-sm font-bold text-slate-700">PIC</label><input name="pic" value="{{ old('pic', $capa->pic) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3"></div>
    <div><label class="mb-2 block text-sm font-bold text-slate-700">Deadline</label><input type="date" name="due_date" value="{{ old('due_date', $capa->due_date?->format('Y-m-d')) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3"></div>
    <div><label class="mb-2 block text-sm font-bold text-slate-700">Status</label><select name="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">@foreach (['open' => 'Open', 'proses' => 'Proses', 'closed' => 'Closed'] as $value => $label)<option value="{{ $value }}" @selected(old('status', $capa->status ?? 'open') === $value)>{{ $label }}</option>@endforeach</select></div>
</div>
@foreach (['root_cause' => 'Akar Masalah', 'corrective_action' => 'Tindakan Korektif', 'preventive_action' => 'Tindakan Pencegahan', 'effectiveness_check' => 'Verifikasi Efektivitas'] as $field => $label)
    <div class="mt-5"><label class="mb-2 block text-sm font-bold text-slate-700">{{ $label }}</label><textarea name="{{ $field }}" rows="4" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3">{{ old($field, $capa->{$field}) }}</textarea></div>
@endforeach
<div class="mt-8 flex flex-col gap-3 sm:flex-row"><button class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button><a href="{{ route('admin.capas.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a></div>
