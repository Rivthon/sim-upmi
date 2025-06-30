@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-6">Edit Dokumen</h2>

    <form action="{{ route('admin.dokumen-upload.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Judul Dokumen</label>
            <input type="text" name="judul" value="{{ old('judul', $dokumen->judul) }}" class="w-full border rounded p-2" required>
            @error('judul') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Kategori</label>
            <select name="kategori_dokumen_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoriList as $kategori)
                    <option value="{{ $kategori->id }}" {{ $dokumen->kategori_dokumen_id == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
            @error('kategori_dokumen_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Sub Kategori --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Sub Kategori</label>
            <select name="sub_kategori_id" class="w-full border rounded p-2">
                <option value="">-- Pilih Sub Kategori --</option>
                @foreach($subKategoriList as $sub)
                    <option value="{{ $sub->id }}" {{ $dokumen->sub_kategori_id == $sub->id ? 'selected' : '' }}>
                        {{ $sub->nama }}
                    </option>
                @endforeach
            </select>
            @error('sub_kategori_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Tipe --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tipe Dokumen</label>
            <select name="tipe" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="Publik" {{ $dokumen->tipe == 'Publik' ? 'selected' : '' }}>Publik</option>
                <option value="Internal" {{ $dokumen->tipe == 'Internal' ? 'selected' : '' }}>Internal</option>
            </select>
            @error('tipe') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- File --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Ganti File (Opsional)</label>
            <input type="file" name="file_path" class="w-full border rounded p-2">
            @if ($dokumen->file_path)
                <p class="text-sm text-blue-600 mt-1">File sekarang: <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="underline">Lihat Dokumen</a></p>
            @endif
            @error('file_path') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
