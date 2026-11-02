@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label for="section" class="mb-2 block text-sm font-bold text-slate-700">Section</label>
        <select name="section" id="section" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
            @foreach ($sections as $key => $label)
                <option value="{{ $key }}" @selected(old('section', $content->section) === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('section') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="key" class="mb-2 block text-sm font-bold text-slate-700">Key Unik</label>
        <input type="text" name="key" id="key" value="{{ old('key', $content->key) }}" placeholder="hero-main / service-ami" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('key') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="title" class="mb-2 block text-sm font-bold text-slate-700">Judul</label>
        <input type="text" name="title" id="title" value="{{ old('title', $content->title) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="subtitle" class="mb-2 block text-sm font-bold text-slate-700">Subtitle / Label Kecil</label>
        <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $content->subtitle) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('subtitle') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="button_label" class="mb-2 block text-sm font-bold text-slate-700">Label Tombol</label>
        <input type="text" name="button_label" id="button_label" value="{{ old('button_label', $content->button_label) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('button_label') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="button_url" class="mb-2 block text-sm font-bold text-slate-700">URL Tombol</label>
        <input type="text" name="button_url" id="button_url" value="{{ old('button_url', $content->button_url) }}" placeholder="/dokumen-publik atau #layanan" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('button_url') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="sort_order" class="mb-2 block text-sm font-bold text-slate-700">Urutan</label>
        <input type="number" min="0" name="sort_order" id="sort_order" value="{{ old('sort_order', $content->sort_order ?? 0) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('sort_order') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="image_path" class="mb-2 block text-sm font-bold text-slate-700">Gambar</label>
        <input type="file" name="image_path" id="image_path" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm">
        @error('image_path') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        @if ($content->image_path)
            <div class="mt-3 flex items-center gap-3">
                <img src="{{ asset('storage/'.$content->image_path) }}" alt="{{ $content->title }}" class="h-14 w-20 rounded-xl object-cover">
                <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remove_image" value="1" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    Hapus gambar
                </label>
            </div>
        @endif
    </div>
</div>

<div class="mt-5">
    <label for="body" class="mb-2 block text-sm font-bold text-slate-700">Isi / Deskripsi</label>
    <textarea name="body" id="body" rows="6" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('body', $content->body) }}</textarea>
    @error('body') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5">
    <label class="inline-flex items-center gap-2 text-sm font-bold text-slate-700">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $content->is_active ?? true)) class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
        Tampilkan di frontend
    </label>
</div>

<div class="mt-8 flex flex-col gap-3 sm:flex-row">
    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">
        Simpan Konten
    </button>
    <a href="{{ route('admin.site-content.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">
        Batal
    </a>
</div>
