@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Upload Dokumen</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
{{-- Kode Dokumen --}}
<div class="mb-4">
    <label class="block font-semibold">Kode Dokumen</label>
    <input type="text" name="kode_dokumen" value="{{ old('kode_dokumen') }}" class="w-full border rounded p-2">
    @error('kode_dokumen') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

{{-- Versi --}}
<div class="mb-4">
    <label class="block font-semibold">Versi</label>
    <input type="text" name="versi" value="{{ old('versi') }}" class="w-full border rounded p-2">
    @error('versi') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

{{-- Tanggal Terbit --}}
<div class="mb-4">
    <label class="block font-semibold">Tanggal Terbit</label>
    <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}" class="w-full border rounded p-2">
    @error('tanggal_terbit') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div>

        {{-- Judul --}}
        <div class="mb-4">
            <label for="judul" class="block text-sm font-semibold mb-1">Judul Dokumen</label>
            <input type="text" name="judul" value="{{ old('judul') }}" class="w-full border p-2 rounded" required>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full border p-2 rounded">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Kategori --}}
        <div class="mb-4">
            <label for="kategori_dokumen_id" class="block text-sm font-semibold mb-1">Kategori</label>
            <select name="kategori_dokumen_id" id="kategori" class="w-full border p-2 rounded" required>
                <option value="">Pilih Kategori</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat->id }}" data-sub="{{ $kat->subKategoris }}">{{ $kat->nama }} ({{ $kat->tipe }})</option>
                @endforeach
            </select>
        </div>

        {{-- Sub Kategori --}}
        <div class="mb-4">
            <label for="sub_kategori_id" class="block text-sm font-semibold mb-1">Sub Kategori</label>
            <select name="sub_kategori_id" id="sub_kategori_id" class="w-full border p-2 rounded">
                <option value="">Pilih Sub Kategori</option>
            </select>
        </div>

        {{-- Tipe --}}
        <div class="mb-4">
            <label for="tipe" class="block text-sm font-semibold mb-1">Tipe Dokumen</label>
            <select name="tipe" class="w-full border p-2 rounded" required>
                <option value="Publik">Publik</option>
                <option value="Internal">Internal</option>
            </select>
        </div>

        {{-- File Upload --}}
        <div class="mb-6">
            <label for="file" class="block text-sm font-semibold mb-1">File</label>
            <input type="file" name="file" class="w-full border p-2 rounded" required>
            <p class="text-sm text-gray-500 mt-1">Format diperbolehkan: PDF, DOC, DOCX, PPT, PPTX, XLS, ZIP (maks. 10MB)</p>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Upload
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const kategoriSelect = document.getElementById('kategori');
    const subKategoriSelect = document.getElementById('sub_kategori_id');

    kategoriSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const subData = selected.getAttribute('data-sub');

        try {
            const subKategoris = JSON.parse(subData.replace(/&quot;/g, '"'));
            subKategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
            subKategoris.forEach(function (sub) {
                const opt = document.createElement('option');
                opt.value = sub.id;
                opt.textContent = sub.nama;
                subKategoriSelect.appendChild(opt);
            });
        } catch (e) {
            subKategoriSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
        }
    });
</script>
@endpush
