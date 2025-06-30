@extends('layouts.admin') {{-- sesuaikan jika pakai layout lain --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Detail Jadwal AMI</h2>

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

        {{-- Detail Informasi Jadwal AMI --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 text-base mb-8">
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Judul</p>
                <p class="text-gray-900 text-lg font-medium">{{ $jadwalAmi->judul }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Tahun</p>
                <p class="text-gray-900 text-lg">{{ $jadwalAmi->tahun }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Unit</p>
                <p class="text-gray-900 text-lg">{{ $jadwalAmi->unit }}</p>
            </div>
            @if($jadwalAmi->unit == 'Tendik')
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Sub Unit</p>
                    <p class="text-gray-900 text-lg">{{ $jadwalAmi->sub_unit ?? '-' }}</p>
                </div>
            @else
                {{-- Placeholder for even columns if Tendik is not selected --}}
                <div>
                    <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Sub Unit</p>
                    <p class="text-gray-900 text-lg">-</p>
                </div>
            @endif

            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Tanggal Mulai</p>
                <p class="text-gray-900 text-lg">{{ \Carbon\Carbon::parse($jadwalAmi->tanggal_mulai)->format('d F Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Tanggal Selesai</p>
                <p class="text-gray-900 text-lg">{{ \Carbon\Carbon::parse($jadwalAmi->tanggal_selesai)->format('d F Y') }}</p>
            </div>
            <div class="sm:col-span-2"> {{-- Ini akan selalu mengambil 2 kolom di SM dan atas --}}
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Status</p>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-base font-semibold leading-tight
                    {{ $jadwalAmi->status === 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $jadwalAmi->status }}
                </span>
            </div>
            <div class="sm:col-span-2">
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Deskripsi</p>
                <p class="text-gray-900 text-lg leading-relaxed whitespace-pre-line">{{ $jadwalAmi->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        {{-- Tim Auditor --}}
        <div class="mb-8 pt-6 border-t border-gray-200">
            <p class="text-gray-500 font-semibold text-sm uppercase mb-3">Tim Auditor</p>
            @if($jadwalAmi->auditors->isNotEmpty())
                <ul class="list-none space-y-2 text-gray-700 text-base">
                    @foreach($jadwalAmi->auditors as $auditor)
                        <li class="flex items-center bg-gray-50 p-3 rounded-lg shadow-sm">
                            <svg class="w-5 h-5 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            <span>{{ $auditor->name }} <span class="text-gray-500 text-sm">({{ $auditor->email }})</span></span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-lg italic">Belum ada auditor yang ditugaskan untuk jadwal ini.</p>
            @endif
        </div>

        {{-- Hasil Temuan & Tindak Lanjut Form --}}
        <form action="{{ route('admin.ami.update_temuan', $jadwalAmi->id) }}" method="POST" class="mt-8 pt-8 border-t-2 border-blue-500">
            @csrf
            @method('PUT')
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Input Hasil Temuan & Tindak Lanjut</h3>

            <div class="mb-5">
                <label for="hasil_temuan" class="block text-gray-700 text-sm font-semibold mb-2">Hasil Temuan</label>
                <textarea id="hasil_temuan" name="hasil_temuan" rows="4" 
                          class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                 transition duration-200 @error('hasil_temuan') border-red-500 @enderror">{{ old('hasil_temuan', $jadwalAmi->hasil_temuan) }}</textarea>
                @error('hasil_temuan') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="tindak_lanjut" class="block text-gray-700 text-sm font-semibold mb-2">Tindak Lanjut</label>
                <textarea id="tindak_lanjut" name="tindak_lanjut" rows="4" 
                          class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                 transition duration-200 @error('tindak_lanjut') border-red-500 @enderror">{{ old('tindak_lanjut', $jadwalAmi->tindak_lanjut) }}</textarea>
                @error('tindak_lanjut') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" 
                        class="bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-md
                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    <svg class="inline-block w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Hasil & Tindak Lanjut
                </button>
            </div>
        </form>

        {{-- Navigasi Bawah --}}
        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.ami.index') }}" 
               class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm
                      transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>
            <a href="{{ route('admin.ami.edit', $jadwalAmi->id) }}" 
               class="inline-flex items-center justify-center px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md
                      transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Jadwal
            </a>
            {{-- Tombol Hapus (hati-hati, biasanya pakai modal konfirmasi) --}}
            <form action="{{ route('admin.ami.destroy', $jadwalAmi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal AMI ini? Tindakan ini tidak bisa dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md
                               transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Jadwal
                </button>
            </form>
        </div>
    </div>
</div>
@endsection