@extends('layouts.admin')

@section('title', 'Upload Dokumen Mutu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Upload Dokumen Mutu</h2>

        {{-- Pesan Error Umum --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-md" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-bold">Terjadi Kesalahan!</p>
                </div>
                <ul class="mt-2 text-sm list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Kode Dokumen --}}
            <div class="mb-5">
                <label for="kode_dokumen" class="block text-gray-700 text-sm font-semibold mb-2">Kode Dokumen</label>
                <input type="text" id="kode_dokumen" name="kode_dokumen" value="{{ old('kode_dokumen') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('kode_dokumen') border-red-500 @enderror" required>
                @error('kode_dokumen') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Judul --}}
            <div class="mb-5">
                <label for="judul" class="block text-gray-700 text-sm font-semibold mb-2">Judul</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('judul') border-red-500 @enderror" required>
                @error('judul') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kategori --}}
            <div class="mb-5">
                <label for="kategori" class="block text-gray-700 text-sm font-semibold mb-2">Kategori</label>
                <select name="kategori_dokumen_id" id="kategori"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('kategori_dokumen_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_dokumen_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }} - {{ ucfirst($kategori->tipe) }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_dokumen_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Sub Kategori (Dynamic) --}}
            <div class="mb-5">
                <label for="sub_kategori_id" class="block text-gray-700 text-sm font-semibold mb-2">Sub Kategori</label>
                <select name="sub_kategori_id" id="sub_kategori_id"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('sub_kategori_id') border-red-500 @enderror">
                    <option value="">-- Pilih Sub Kategori --</option>
                    {{-- Options will be loaded via JavaScript --}}
                    @if (old('sub_kategori_id'))
                        @php
                            $selectedSubId = old('sub_kategori_id');
                            $selectedSub = \App\Models\SubKategoriDokumen::find($selectedSubId);
                        @endphp
                        @if ($selectedSub)
                            <option value="{{ $selectedSub->id }}" selected>{{ $selectedSub->nama }}</option>
                        @endif
                    @endif
                </select>
                @error('sub_kategori_id') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="mb-5">
                <label for="status" class="block text-gray-700 text-sm font-semibold mb-2">Status</label>
                <select name="status" id="status"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('status') border-red-500 @enderror" required>
                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Revisi" {{ old('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                    <option value="Tidak Berlaku" {{ old('status') == 'Tidak Berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                </select>
                @error('status') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Versi --}}
            <div class="mb-5">
                <label for="versi" class="block text-gray-700 text-sm font-semibold mb-2">Versi</label>
                <input type="text" id="versi" name="versi" value="{{ old('versi') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('versi') border-red-500 @enderror">
                @error('versi') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Terbit --}}
            <div class="mb-5">
                <label for="tanggal_terbit" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Terbit</label>
                <input type="date" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('tanggal_terbit') border-red-500 @enderror">
                @error('tanggal_terbit') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-5">
                <label for="deskripsi" class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                 transition duration-200 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tipe Dokumen (Publik/Internal) --}}
            <div class="mb-5">
                <label for="tipe_dokumen" class="block text-gray-700 text-sm font-semibold mb-2">Tipe Dokumen</label>
                <select name="tipe" id="tipe_dokumen"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('tipe') border-red-500 @enderror" required>
                    <option value="Publik" {{ old('tipe') == 'Publik' ? 'selected' : '' }}>Publik</option>
                    <option value="Internal" {{ old('tipe') == 'Internal' ? 'selected' : '' }}>Internal</option>
                </select>
                @error('tipe') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- File Upload --}}
            <div class="mb-6">
                <label for="file_path" class="block text-gray-700 text-sm font-semibold mb-2">Upload File (PDF)</label>
                <input type="file" id="file_path" name="file_path" accept="application/pdf"
                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('file_path') border-red-500 @enderror" required>
                <p class="text-sm text-gray-500 mt-2">Format file yang diterima: PDF.</p>
                @error('file_path') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.dokumen.index') }}"
                   class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm
                          transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center bg-blue-600 text-white font-bold py-2.5 px-6 rounded-lg shadow-md
                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Dokumen
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const kategoriSelect = document.getElementById('kategori');
    const subKategoriSelect = document.getElementById('sub_kategori_id');
    const oldSubKategoriId = "{{ old('sub_kategori_id') }}";

    function loadSubKategoris(kategoriId, selectedSubId = null) {
        subKategoriSelect.innerHTML = '<option value="">-- Memuat Sub Kategori --</option>'; // Loading state
        
        if (!kategoriId) {
            subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';
            return;
        }

        fetch(`/api/subkategoris-by-kategori/${kategoriId}`) // Adjust API endpoint if needed
            .then(response => response.json())
            .then(data => {
                subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';
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
            .catch(error => {
                console.error('Error fetching subkategoris:', error);
                subKategoriSelect.innerHTML = '<option value="">-- Gagal memuat sub kategori --</option>';
            });
    }

    // Initial load based on old input
    const initialKategoriId = kategoriSelect.value;
    if (initialKategoriId) {
        loadSubKategoris(initialKategoriId, oldSubKategoriId);
    } else {
        // If no category is selected initially, clear sub-category
        subKategoriSelect.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';
    }

    // Event listener for category change
    kategoriSelect.addEventListener('change', function () {
        loadSubKategoris(this.value);
    });
});
</script>
@endpush
@endsection