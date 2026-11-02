@extends('layouts.user')

@section('title', 'Isi Survei')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-4 pb-3 border-b-2 border-blue-500">Survei: <span class="text-blue-600">{{ $survey->judul }}</span></h2>
        <p class="text-gray-700 text-lg leading-relaxed mb-8">{{ $survey->deskripsi }}</p>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-md" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="font-bold">Mohon periksa kembali jawaban Anda!</p>
                </div>
                <ul class="mt-2 text-sm list-disc ml-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user.survey.store', $survey->id) }}">
            @csrf

            <div class="space-y-8"> {{-- Added space-y for consistent spacing between questions --}}
                @forelse ($survey->questions as $index => $question)
                    <div class="p-6 rounded-xl bg-gray-50 shadow-sm border border-gray-200">
                        <label class="block text-xl font-semibold text-gray-800 mb-4">{{ $loop->iteration }}. {{ $question->pertanyaan }}</label>

                        @if ($question->tipe == 'pilihan') {{-- Changed from 'pilihan' to 'pilihan_tunggal' --}}
                            <div class="space-y-2">
                                @foreach ($question->opsi as $opsi)
                                    <label class="flex items-center text-gray-800 text-base cursor-pointer">
                                        <input type="radio" name="jawaban[{{ $question->id }}]" value="{{ $opsi }}" 
                                               class="form-radio h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500" 
                                               {{ (old('jawaban.' . $question->id) == $opsi) ? 'checked' : '' }}>
                                        <span class="ml-2">{{ $opsi }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('jawaban.' . $question->id) <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        @elseif ($question->tipe == 'ganda') {{-- Changed from 'ganda' to 'pilihan_ganda' --}}
                            <div class="space-y-2">
                                @foreach ($question->opsi as $opsi)
                                    <label class="flex items-center text-gray-800 text-base cursor-pointer">
                                        <input type="checkbox" name="jawaban_{{ $question->id }}[]" value="{{ $opsi }}"
                                               class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500" 
                                               {{ (is_array(old('jawaban.' . $question->id)) && in_array($opsi, old('jawaban.' . $question->id))) ? 'checked' : '' }}>
                                        <span class="ml-2">{{ $opsi }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('jawaban.' . $question->id) <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        @elseif ($question->tipe == 'skala')
                            <div class="mt-2 flex flex-wrap gap-2 justify-center sm:justify-start">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="jawaban[{{ $question->id }}]" value="{{ $i }}" class="sr-only peer" {{ (old('jawaban.' . $question->id) == $i) ? 'checked' : '' }}>
                                        <span class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg text-lg font-bold shadow-sm transition duration-150 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:ring-2 peer-checked:ring-blue-500 hover:bg-gray-300">
                                            {{ $i }}
                                        </span>
                                    </label>
                                @endfor
                                <p class="text-gray-600 text-sm mt-2 sm:ml-4 sm:mt-0"> (Skala 1: Sangat Tidak Setuju, 5: Sangat Setuju)</p>
                            </div>
                            @error('jawaban.' . $question->id) <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        @elseif ($question->tipe == 'teks')
                            <textarea name="jawaban[{{ $question->id }}]" rows="5" 
                                      class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                             focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                             transition duration-200 @error('jawaban.' . $question->id) border-red-500 @enderror" 
                                      placeholder="Ketik jawaban Anda di sini...">{{ old('jawaban.' . $question->id) }}</textarea>
                            @error('jawaban.' . $question->id) <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        @endif
                    </div>
                @empty
                    <div class="p-6 text-center bg-gray-50 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-gray-600 text-lg italic">Tidak ada pertanyaan yang tersedia untuk survei ini.</p>
                        <p class="text-gray-500 mt-2">Silakan hubungi Admin UPMI.</p>
                    </div>
                @endforelse
            </div>

            <div class="flex justify-end space-x-4 mt-10 pt-6 border-t border-gray-200">
                <a href="{{ route('user.survey.index') }}"
                   class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm
                          transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center bg-blue-600 text-white font-bold py-2.5 px-6 rounded-lg shadow-md
                           hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                           transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Kirim Jawaban
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
