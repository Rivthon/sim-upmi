@extends('layouts.admin')

@section('title', 'Edit Pertanyaan Survei')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Edit Pertanyaan untuk: <span class="text-blue-600">{{ $survey->judul }}</span></h2>

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

        <form action="{{ route('admin.survey.pertanyaan.update', [$survey->id, $pertanyaan->id]) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pertanyaan --}}
            <div class="mb-5">
                <label for="pertanyaan" class="block text-gray-700 text-sm font-semibold mb-2">Pertanyaan</label>
                <input type="text" name="pertanyaan" id="pertanyaan" value="{{ old('pertanyaan', $pertanyaan->pertanyaan) }}"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('pertanyaan') border-red-500 @enderror" required>
                @error('pertanyaan') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tipe --}}
            <div class="mb-5">
                <label for="tipe-select" class="block text-gray-700 text-sm font-semibold mb-2">Tipe Jawaban</label>
                <select name="tipe" id="tipe-select"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('tipe') border-red-500 @enderror" required>
                    <option value="text" {{ old('tipe', $pertanyaan->tipe) === 'text' ? 'selected' : '' }}>Teks Bebas</option>
                    <option value="skala" {{ old('tipe', $pertanyaan->tipe) === 'skala' ? 'selected' : '' }}>Skala (1–5)</option>
                    <option value="pilihan_tunggal" {{ old('tipe', $pertanyaan->tipe) === 'pilihan_tunggal' ? 'selected' : '' }}>Pilihan Tunggal</option>
                    <option value="pilihan_ganda" {{ old('tipe', $pertanyaan->tipe) === 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                </select>
                @error('tipe') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Opsi Jawaban (Conditional) --}}
            <div class="mb-6" id="opsi-wrapper" style="{{ in_array(old('tipe', $pertanyaan->tipe), ['pilihan_tunggal', 'pilihan_ganda']) ? '' : 'display: none;' }}">
                <label for="opsi" class="block text-gray-700 text-sm font-semibold mb-2">Opsi Jawaban (Pisahkan dengan koma)</label>
                <input type="text" name="opsi" id="opsi"
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('opsi') border-red-500 @enderror"
                       value="{{ old('opsi', is_array($pertanyaan->opsi) ? implode(', ', $pertanyaan->opsi) : '') }}"
                       placeholder="Contoh: Sangat Baik, Baik, Cukup, Kurang Baik, Sangat Kurang">
                <p class="text-xs text-gray-500 mt-1">Gunakan koma (,) untuk memisahkan setiap opsi.</p>
                @error('opsi') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.survey.show', $survey->id) }}" {{-- Kembali ke detail survei --}}
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipeSelect = document.getElementById('tipe-select');
        const opsiWrapper = document.getElementById('opsi-wrapper');
        const opsiInput = document.querySelector('#opsi-wrapper input[name="opsi"]');

        function toggleOpsiField() {
            const tipe = tipeSelect.value;
            if (tipe === 'pilihan_tunggal' || tipe === 'pilihan_ganda') {
                opsiWrapper.style.display = 'block';
                opsiInput.setAttribute('required', 'required'); // Make required when visible
            } else {
                opsiWrapper.style.display = 'none';
                opsiInput.removeAttribute('required'); // Remove required when hidden
                opsiInput.value = ''; // Clear value when hidden
            }
        }

        // Initialize on page load
        toggleOpsiField();

        // Add event listener for change
        tipeSelect.addEventListener('change', toggleOpsiField);
    });
</script>
@endsection