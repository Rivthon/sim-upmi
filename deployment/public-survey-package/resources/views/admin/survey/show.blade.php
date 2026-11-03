@extends('layouts.admin')

@section('title', 'Detail Survei')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Detail Survei: {{ $survey->judul }}</h2>

        {{-- Detail Informasi Survei --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-base mb-8">
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Judul Survei</p>
                <p class="text-gray-900 text-lg font-medium">{{ $survey->judul }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Status</p>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-base font-semibold leading-tight
                    {{ $survey->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($survey->status) }}
                </span>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Deskripsi</p>
                <p class="text-gray-900 text-lg leading-relaxed whitespace-pre-line">{{ $survey->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Target Survei</p>
                <div class="flex flex-wrap gap-2 mt-2">
                    @forelse($survey->targets as $target)
                        <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full shadow-sm">
                            {{ ucfirst($target->target) }}
                        </span>
                    @empty
                        <p class="text-gray-500 italic text-lg">Belum ada target yang ditentukan.</p>
                    @endforelse
                </div>
            </div>
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Tanggal Dibuat</p>
                <p class="text-gray-900 text-lg">{{ \Carbon\Carbon::parse($survey->created_at)->format('d F Y') }}</p>
            </div>
        </div>

        {{-- Tombol Aksi untuk Survey (Edit, Hapus) --}}
        <div class="flex justify-end space-x-4 mb-8 pt-4 border-t border-gray-200">
                        
        <a href="{{ route('admin.survey.hasil', $survey->id) }}"
               class="inline-flex items-center px-6 py-2.5 bg-green-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:scale-105">
                <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Lihat Jawaban
            </a>
            <a href="{{ route('admin.survey.edit', $survey->id) }}"
               class="inline-flex items-center px-6 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:scale-105">
                <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Survei
            </a>
            <form action="{{ route('admin.survey.destroy', $survey->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus survei ini dan semua pertanyaan serta responnya? Tindakan ini tidak bisa dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:scale-105">
                    <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Survei
                </button>
            </form>
        </div>


        {{-- Preview Pertanyaan --}}
        <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-4 pt-4">Pratinjau Pertanyaan Survei</h3>

        @forelse ($survey->questions as $q)
            <div class="mb-6 p-6 rounded-xl bg-white shadow-md border border-gray-200">
                <div class="flex justify-between items-center mb-3">
                    <p class="text-xl font-semibold text-gray-800">{{ $loop->iteration }}. {{ $q->pertanyaan }}</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.survey.pertanyaan.edit', ['survey' => $survey->id, 'pertanyaan' => $q->id]) }}" class="text-yellow-600 hover:text-yellow-800 transition duration-200" title="Edit Pertanyaan">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form action="{{ route('admin.survey.pertanyaan.destroy', ['survey' => $survey->id, 'pertanyaan' => $q->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini? Respon terkait juga akan terhapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition duration-200" title="Hapus Pertanyaan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Tipe Pertanyaan dan Opsi --}}
                <p class="text-gray-600 text-sm italic mb-3">Tipe: {{ ucfirst($q->tipe) }}</p>

                @if ($q->tipe == 'skala')
                    <div class="mt-2 flex flex-wrap gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg text-lg font-bold shadow-sm transition duration-150 hover:bg-gray-300 cursor-not-allowed">{{ $i }}</span>
                        @endfor
                        <span class="text-gray-500 text-sm ml-2"> (Skala 1-5)</span>
                    </div>
                @elseif ($q->tipe == 'text')
                    <input type="text" disabled class="mt-2 w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-100 text-gray-700 shadow-sm cursor-not-allowed" placeholder="Contoh Jawaban Teks Panjang...">
                @elseif ($q->tipe == 'pilihan_tunggal')
                    <div class="space-y-2 mt-2">
                        @foreach ($q->opsi as $opsi)
                            <label class="flex items-center text-gray-800 text-base">
                                <input type="radio" disabled class="form-radio h-5 w-5 text-blue-600 border-gray-300 cursor-not-allowed">
                                <span class="ml-2">{{ $opsi }}</span>
                            </label>
                        @endforeach
                    </div>
                @elseif ($q->tipe == 'pilihan_ganda')
                    <div class="space-y-2 mt-2">
                        @foreach ($q->opsi as $opsi)
                            <label class="flex items-center text-gray-800 text-base">
                                <input type="checkbox" disabled class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 cursor-not-allowed">
                                <span class="ml-2">{{ $opsi }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="p-6 text-center bg-gray-50 rounded-xl shadow-sm border border-gray-200">
                <p class="text-gray-600 text-lg italic">Belum ada pertanyaan yang ditambahkan untuk survei ini.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.survey.pertanyaan.create', $survey->id) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Mulai Tambah Pertanyaan
                    </a>
                </div>
            </div>
        @endforelse
        
        {{-- Tombol Kembali --}}
        <div class="flex justify-start mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.survey.index') }}" 
               class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Survei
            </a>
        </div>
    </div>
</div>
@endsection