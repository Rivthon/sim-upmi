@csrf
@php
    $selectedTargets = old('target', $survey?->targets?->pluck('target')->all() ?? ['Umum']);
    $startsAt = old('starts_at', $survey?->starts_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i'));
    $endsAt = old('ends_at', $survey?->ends_at?->format('Y-m-d\TH:i') ?? now()->addDays(2)->format('Y-m-d\TH:i'));
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
        <p class="font-extrabold">Data survey belum valid.</p>
        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div>
    <label for="judul" class="mb-2 block text-sm font-extrabold text-slate-700">Judul Survey</label>
    <input id="judul" name="judul" type="text" value="{{ old('judul', $survey?->judul) }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500" placeholder="Contoh: Survey Kepuasan Layanan Akademik" required>
    @error('judul') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5">
    <label for="deskripsi" class="mb-2 block text-sm font-extrabold text-slate-700">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">{{ old('deskripsi', $survey?->deskripsi) }}</textarea>
</div>

<div class="mt-5 grid gap-5 md:grid-cols-2">
    <div>
        <label for="starts_at" class="mb-2 block text-sm font-extrabold text-slate-700">Mulai Pengisian</label>
        <input id="starts_at" name="starts_at" type="datetime-local" value="{{ $startsAt }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        @error('starts_at') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="ends_at" class="mb-2 block text-sm font-extrabold text-slate-700">Berakhir Otomatis</label>
        <input id="ends_at" name="ends_at" type="datetime-local" value="{{ $endsAt }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 focus:border-teal-500 focus:ring-teal-500">
        <p class="mt-2 text-xs text-slate-500">Default dua hari. Setelah waktu ini link ditolak oleh server.</p>
        @error('ends_at') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-5 rounded-2xl border border-white/70 bg-white/55 p-5">
    <p class="text-sm font-extrabold text-slate-800">Target Survey</p>
    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @foreach (['Umum', 'Prodi D3 Kebidanan', 'Prodi S1 Farmasi', 'Prodi S1 Gizi', 'Tendik', 'Mahasiswa'] as $target)
            <label class="flex cursor-pointer items-center gap-3 rounded-xl bg-white/70 px-4 py-3 text-sm font-semibold text-slate-700 ring-1 ring-white">
                <input type="checkbox" name="target[]" value="{{ $target }}" @checked(in_array($target, $selectedTargets)) class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                {{ $target }}
            </label>
        @endforeach
    </div>
    @error('target') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="mt-5 grid gap-4 sm:grid-cols-2">
    <label class="flex cursor-pointer items-center justify-between rounded-2xl border border-white/70 bg-white/60 p-5">
        <span><span class="block font-extrabold text-slate-800">Aktifkan Survey</span><span class="mt-1 block text-xs text-slate-500">Survey dapat diisi pada periode yang ditentukan.</span></span>
        <input type="checkbox" name="is_aktif" value="1" @checked(old('is_aktif', $survey?->is_aktif ?? true)) class="h-5 w-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
    </label>
    <label class="flex cursor-pointer items-center justify-between rounded-2xl border border-white/70 bg-white/60 p-5">
        <span><span class="block font-extrabold text-slate-800">Link Publik</span><span class="mt-1 block text-xs text-slate-500">Siapa pun dengan link dapat mengisi tanpa login.</span></span>
        <input type="checkbox" name="is_public" value="1" @checked(old('is_public', $survey?->is_public ?? true)) class="h-5 w-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
    </label>
</div>

<div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <a href="{{ route('admin.survey.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">Batal</a>
    <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-extrabold text-white hover:bg-teal-700">Simpan Survey</button>
</div>
