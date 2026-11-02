@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-3">
        {{ isset($pelaporan) ? 'Edit Pelaporan SPMI' : 'Tambah Pelaporan SPMI' }}
    </h1>

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

<form action="{{ route('admin.pelaporan.update', $pelaporan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

        {{-- Unit (readonly) --}}
            <div class="mb-5">
                <label for="unit" class="block text-gray-700 text-sm font-semibold mb-2">Unit</label>
                <select name="unit" id="unit" 
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('unit') border-red-500 @enderror" required>
                    <option value="">Pilih Unit</option>
                    <option value="Prodi D3 Kebidanan" {{ old('unit', $pelaporan->unit ?? '') == 'Prodi D3 Kebidanan' ? 'selected' : '' }}>Prodi D3 Kebidanan</option>
                    <option value="Prodi S1 Farmasi" {{ old('unit', $pelaporan->unit ?? '') == 'Prodi S1 Farmasi' ? 'selected' : '' }} >Prodi S1 Farmasi</option>
                    <option value="Prodi S1 Gizi" {{ old('unit', $pelaporan->unit ?? '') == 'Prodi S1 Gizi' ? 'selected' : '' }}>Prodi S1 Gizi</option>
                    <option value="Tendik" {{ old('unit', $pelaporan->unit ?? '') == 'Tendik' ? 'selected' : '' }}>Tendik</option>
                </select>
                @error('unit') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-5 {{ old('unit') == 'Tendik' ? '' : 'hidden' }}" id="sub-unit-wrapper">
                <label for="sub_unit" class="block text-gray-700 text-sm font-semibold mb-2">Sub Unit</label>
                <select name="sub_unit" id="sub_unit" 
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('sub_unit') border-red-500 @enderror">
                    <option value="">Pilih Sub Unit</option>
                    <option value="Laboran Farmasi" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'Laboran Farmasi' ? 'selected' : '' }}>Laboran Farmasi</option>
                    <option value="Laboran Gizi" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'Laboran Gizi' ? 'selected' : '' }}>Laboran Gizi</option>
                    <option value="Laboran Bidan" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'Laboran Bidan' ? 'selected' : '' }}>Laboran Bidan</option>
                    <option value="Perpustakaan" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'Perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                    <option value="ICT" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'ICT' ? 'selected' : '' }}>ICT</option>
                    <option value="BAAK" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'BAAK' ? 'selected' : '' }}>BAAK</option>
                    <option value="OPERATOR" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'OPERATOR' ? 'selected' : '' }}>OPERATOR</option>
                    <option value="BAUK" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'BAUK' ? 'selected' : '' }}>BAUK</option>
                    <option value="SARPRAS" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'SARPRAS' ? 'selected' : '' }}>SARPRAS</option>
                    <option value="SDM" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'SDM' ? 'selected' : '' }}>SDM</option>
                    <option value="KERJASAMA" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'KERJASAMA' ? 'selected' : '' }}>KERJASAMA</option>
                    <option value="HUMAS" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'HUMAS' ? 'selected' : '' }}>HUMAS</option>
                    <option value="KEMAHASISWAAN" {{ old('sub_unit', $pelaporan->sub_unit ?? '') == 'KEMAHASISWAAN' ? 'selected' : '' }}>KEMAHASISWAAN</option>
                </select>
                @error('sub_unit') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>
        {{-- Judul --}}
        <div class="mb-5">
            <label for="judul" class="block text-gray-700 text-sm font-semibold mb-2">Judul</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $pelaporan->judul ?? '') }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('judul') border-red-500 @enderror">
            @error('judul')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Periode --}}
        <div class="mb-5">
            <label for="periode" class="block text-gray-700 text-sm font-semibold mb-2">Periode</label>
            <input type="text" id="periode" name="periode" value="{{ old('periode', $pelaporan->periode ?? '') }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('periode') border-red-500 @enderror">
            @error('periode')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tahapan --}}
        <div class="mb-5">
            <label for="tahapan" class="block text-gray-700 text-sm font-semibold mb-2">Tahapan</label>
<select id="tahapan" name="tahapan" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('tahapan') border-red-500 @enderror">

<option value="Penetapan" {{ old('tahapan', $pelaporan->tahapan ?? '') == 'Penetapan' ? 'selected' : '' }}>Penetapan</option>
<option value="Pelaksanaan" {{ old('tahapan', $pelaporan->tahapan ?? '') == 'Pelaksanaan' ? 'selected' : '' }}>Pelaksanaan</option>
<option value="Evaluasi" {{ old('tahapan', $pelaporan->tahapan ?? '') == 'Evaluasi' ? 'selected' : '' }}>Evaluasi</option>
<option value="Pengendalian" {{ old('tahapan', $pelaporan->tahapan ?? '') == 'Pengendalian' ? 'selected' : '' }}>Pengendalian</option>
<option value="Peningkatan" {{ old('tahapan', $pelaporan->tahapan ?? '') == 'Peningkatan' ? 'selected' : '' }}>Peningkatan</option>
           
        </select>
@error('tahapan')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-5">
            <label for="deskripsi" class="block text-gray-700 text-sm font-semibold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $pelaporan->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div class="mb-5">
            <label for="tanggal" class="block text-gray-700 text-sm font-semibold mb-2">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', isset($pelaporan) ? $pelaporan->tanggal : '') }}" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('tanggal') border-red-500 @enderror">
            @error('tanggal')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-5">
            <label for="status" class="block text-gray-700 text-sm font-semibold mb-2">Status</label>
            <select id="status" name="status" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                <option value="Draft" {{ (old('status', $pelaporan->status ?? '') == 'Draft') ? 'selected' : '' }}>Draft</option>
                <option value="Final" {{ (old('status', $pelaporan->status ?? '') == 'Final') ? 'selected' : '' }}>Final</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

{{-- Bukti Pendukung --}}
<div class="mb-5">
    <label for="bukti_pendukung" class="block text-gray-700 text-sm font-semibold mb-2">Bukti Pendukung (PDF/JPG/PNG)</label>

    @if($pelaporan->bukti_pendukung)
        <p class="mb-2 text-sm text-gray-600">
            <strong>File saat ini:</strong> 
            <a href="{{ route('admin.pelaporan.download', $pelaporan->id) }}" class="text-blue-600 underline">
                {{ basename($pelaporan->bukti_pendukung) }}
            </a>
        </p>
    @endif

    <input type="file" id="bukti_pendukung" name="bukti_pendukung"
        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 @error('bukti_pendukung') border-red-500 @enderror">
    
    @error('bukti_pendukung')
        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror

    <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah file.</p>
</div>


        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white font-bold py-2 px-6 rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300 ease-in-out">
            {{ isset($pelaporan) ? 'Update Pelaporan' : 'Simpan Pelaporan' }}
        </button>
    </form>
</div>
@endsection
