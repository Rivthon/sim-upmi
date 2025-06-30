@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">Daftar Dokumen</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 text-right">
        <a href="{{ route('admin.dokumen-upload.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Upload Dokumen Baru
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Judul</th>
                    <th class="px-4 py-2 border">Kategori</th>
                    <th class="px-4 py-2 border">Sub Kategori</th>
                    <th class="px-4 py-2 border">Tipe</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dokumen as $doc)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border font-medium">{{ $doc->judul }}</td>
                    <td class="px-4 py-2 border">{{ $doc->kategoriDokumen->nama ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $doc->subKategori?->nama ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $doc->tipe }}</td>
                    <td class="px-4 py-2 border space-x-2">
                        <a href="{{ route('admin.dokumen-upload.show', $doc->id) }}"
                           class="inline-block text-blue-600 hover:underline">Lihat</a>
                        <a href="{{ route('admin.dokumen-upload.edit', $doc->id) }}"
                           class="inline-block text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.dokumen-upload.destroy', $doc->id) }}" method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-500">Belum ada dokumen yang diunggah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
