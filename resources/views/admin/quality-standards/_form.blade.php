@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Kode Standar</label>
        <input type="text" name="code" value="{{ old('code', $standard->code) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
        @error('code') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-slate-700">Kategori</label>
        <input type="text" name="category" value="{{ old('category', $standard->category) }}" placeholder="Pendidikan / Penelitian / Pengabdian" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('category') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Nama Standar</label>
    <input type="text" name="name" value="{{ old('name', $standard->name) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" required>
    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5">
    <label class="mb-2 block text-sm font-bold text-slate-700">Deskripsi</label>
    <textarea name="description" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('description', $standard->description) }}</textarea>
    @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<label class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-slate-700">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $standard->is_active ?? true)) class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
    Aktif
</label>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan</button>
    <a href="{{ route('admin.quality-standards.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
</div>
