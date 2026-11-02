@extends('layouts.admin')

@section('title', 'Upload Dokumen Mutu')

@section('content')
<div class="mx-auto max-w-6xl">
    <section class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Dokumen Mutu</p>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-950 md:text-4xl">Upload Dokumen Mutu</h2>
                <p class="mt-2 max-w-2xl leading-7 text-slate-600">Unggah dokumen, tentukan metadata, dan kirim ke workflow approval dokumen.</p>
            </div>
            <a href="{{ route('admin.dokumen.index') }}" class="rounded-2xl bg-white/75 px-5 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">
                Kembali
            </a>
        </div>
    </section>

    @if ($errors->any())
        <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <p class="font-extrabold">Terjadi kesalahan.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-6 lg:grid-cols-[1.35fr_.65fr]">
        @csrf

        @if ($dokumenDirevisi)
            <input type="hidden" name="revisi_dari" value="{{ $dokumenDirevisi->id }}">
        @endif

        <div class="admin-glass rounded-[1.5rem] p-6">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="kode_dokumen" class="mb-2 block text-sm font-bold text-slate-700">Kode Dokumen</label>
                    <input type="text" id="kode_dokumen" name="kode_dokumen" value="{{ old('kode_dokumen') }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                    @error('kode_dokumen') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="versi" class="mb-2 block text-sm font-bold text-slate-700">Versi</label>
                    <input type="text" id="versi" name="versi" value="{{ old('versi') }}" placeholder="v1.0" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                    @error('versi') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="judul" class="mb-2 block text-sm font-bold text-slate-700">Judul Dokumen</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                @error('judul') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label for="kategori" class="mb-2 block text-sm font-bold text-slate-700">Kategori</label>
                    <select name="kategori_dokumen_id" id="kategori" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected(old('kategori_dokumen_id') == $kategori->id)>
                                {{ $kategori->nama }} - {{ ucfirst($kategori->tipe) }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_dokumen_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="sub_kategori_id" class="mb-2 block text-sm font-bold text-slate-700">Sub Kategori</label>
                    <select name="sub_kategori_id" id="sub_kategori_id" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                        <option value="">Pilih Sub Kategori</option>
                        @if (old('sub_kategori_id'))
                            @php($selectedSub = \App\Models\SubKategoriDokumen::find(old('sub_kategori_id')))
                            @if ($selectedSub)
                                <option value="{{ $selectedSub->id }}" selected>{{ $selectedSub->nama }}</option>
                            @endif
                        @endif
                    </select>
                    @error('sub_kategori_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-3">
                <div>
                    <label for="status" class="mb-2 block text-sm font-bold text-slate-700">Status Dokumen</label>
                    <select name="status" id="status" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                        @foreach (['Aktif', 'Revisi', 'Tidak Berlaku'] as $status)
                            <option value="{{ $status }}" @selected(old('status', 'Aktif') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="tipe_dokumen" class="mb-2 block text-sm font-bold text-slate-700">Tipe</label>
                    <select name="tipe" id="tipe_dokumen" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                        <option value="Publik" @selected(old('tipe', 'Publik') === 'Publik')>Publik</option>
                        <option value="Internal" @selected(old('tipe') === 'Internal')>Internal</option>
                    </select>
                    @error('tipe') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="tanggal_terbit" class="mb-2 block text-sm font-bold text-slate-700">Tanggal Terbit</label>
                    <input type="date" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500" required>
                    @error('tanggal_terbit') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-5">
                <label for="deskripsi" class="mb-2 block text-sm font-bold text-slate-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="5" class="w-full rounded-2xl border-slate-200 bg-white/80 px-4 py-3 text-slate-900 focus:border-teal-500 focus:ring-teal-500">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <aside class="space-y-6">
            @if ($dokumenDirevisi)
                <div class="admin-glass rounded-[1.5rem] p-6">
                    <p class="text-sm font-extrabold uppercase tracking-[0.18em] text-orange-700">Mode Revisi</p>
                    <h3 class="mt-2 text-xl font-extrabold text-slate-950">{{ $dokumenDirevisi->kode_dokumen }}</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $dokumenDirevisi->judul }}</p>
                </div>
            @endif

            <div class="admin-glass rounded-[1.5rem] p-6">
                <h3 class="text-xl font-extrabold text-slate-950">File Dokumen</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">File akan disimpan berdasarkan tipe dokumen. Dokumen publik masuk storage publik, internal tetap privat.</p>
                <div class="mt-5 rounded-2xl border border-dashed border-teal-300 bg-white/55 p-5">
                    <label for="file_path" class="mb-3 block text-sm font-bold text-slate-700">Upload File</label>
                    <input type="file" id="file_path" name="file_path" accept=".pdf,.doc,.docx,.xls,.xlsx" class="w-full rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 text-sm file:mr-4 file:rounded-full file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-teal-700 hover:file:bg-teal-100" required>
                    <p class="mt-3 text-xs leading-5 text-slate-500">Format: PDF, DOC, DOCX, XLS, XLSX. Maksimal 5 MB.</p>
                    @error('file_path') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="admin-glass rounded-[1.5rem] p-6">
                <h3 class="text-xl font-extrabold text-slate-950">Workflow</h3>
                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white/80">
                        <p class="text-sm font-bold text-slate-500">Approval</p>
                        <p class="mt-1 font-extrabold text-amber-700">Pending setelah upload</p>
                    </div>
                    <div class="rounded-2xl bg-white/65 p-4 ring-1 ring-white/80">
                        <p class="text-sm font-bold text-slate-500">Versioning</p>
                        <p class="mt-1 font-extrabold text-teal-700">Versi otomatis dicatat</p>
                    </div>
                </div>
                <div class="mt-6 grid gap-3">
                    <button type="submit" class="rounded-2xl bg-teal-600 px-6 py-3 text-sm font-extrabold text-white shadow-lg shadow-teal-700/20 hover:bg-teal-700">
                        Simpan Dokumen
                    </button>
                    <a href="{{ route('admin.dokumen.index') }}" class="rounded-2xl bg-white/80 px-6 py-3 text-center text-sm font-extrabold text-slate-700 ring-1 ring-white hover:bg-white">
                        Batal
                    </a>
                </div>
            </div>
        </aside>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kategoriSelect = document.getElementById('kategori');
    const subKategoriSelect = document.getElementById('sub_kategori_id');
    const oldSubKategoriId = "{{ old('sub_kategori_id') }}";

    function loadSubKategoris(kategoriId, selectedSubId = null) {
        subKategoriSelect.innerHTML = '<option value="">Memuat Sub Kategori...</option>';

        if (!kategoriId) {
            subKategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
            return;
        }

        fetch(`/api/subkategoris-by-kategori/${kategoriId}`)
            .then(response => response.json())
            .then(data => {
                subKategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
                data.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.nama;
                    if (selectedSubId && sub.id == selectedSubId) {
                        option.selected = true;
                    }
                    subKategoriSelect.appendChild(option);
                });
            })
            .catch(() => {
                subKategoriSelect.innerHTML = '<option value="">Gagal memuat sub kategori</option>';
            });
    }

    if (kategoriSelect.value) {
        loadSubKategoris(kategoriSelect.value, oldSubKategoriId);
    }

    kategoriSelect.addEventListener('change', function () {
        loadSubKategoris(this.value);
    });
});
</script>
@endpush
@endsection
