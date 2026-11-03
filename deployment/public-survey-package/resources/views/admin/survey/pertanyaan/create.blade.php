@extends('layouts.admin')

@section('title', 'Tambah Pertanyaan Survei')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Tambah Pertanyaan untuk: <span class="text-blue-600">{{ $survey->judul }}</span></h2>
        
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

        <form action="{{ route('admin.survey.pertanyaan.store', $survey->id) }}" method="POST">
            @csrf

            <div id="pertanyaan-wrapper" class="space-y-8"> {{-- Added space-y for consistent spacing between questions --}}
                <div class="pertanyaan p-6 border border-gray-200 rounded-xl shadow-sm relative"> {{-- Card styling for each question --}}
                    {{-- Delete button for cloned questions --}}
                    <button type="button" class="delete-question-btn absolute top-3 right-3 text-red-500 hover:text-red-700 focus:outline-none hidden" title="Hapus Pertanyaan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>

                    <label class="block text-gray-700 text-sm font-semibold mb-2">Pertanyaan</label>
                    <input type="text" name="pertanyaan[]"
                           class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                  transition duration-200 @error('pertanyaan.*') border-red-500 @enderror" required>
                    @error('pertanyaan.*') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror

                    <label class="block text-gray-700 text-sm font-semibold mb-2 mt-4">Tipe Jawaban</label>
                    <select name="tipe[]"
                            class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                   transition duration-200 tipe-select @error('tipe.*') border-red-500 @enderror" required>
                        <option value="teks">Teks Bebas</option>
                        <option value="skala">Skala (1–5)</option>
                        <option value="pilihan">Pilihan Tunggal</option> {{-- Updated value for consistency --}}
                        <option value="ganda">Pilihan Ganda</option> {{-- Updated value for consistency --}}
                    </select>
                    @error('tipe.*') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror

                    <div class="opsi-wrapper mt-4 hidden">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Opsi Jawaban (Pisahkan dengan koma)</label>
                        <input type="text" name="opsi[]"
                               class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      transition duration-200 @error('opsi.*') border-red-500 @enderror" placeholder="Contoh: Sangat Baik, Baik, Cukup, Kurang Baik, Sangat Kurang">
                        <p class="text-xs text-gray-500 mt-1">Gunakan koma (,) untuk memisahkan setiap opsi.</p>
                        @error('opsi.*') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <button type="button" id="tambah-pertanyaan"
                    class="inline-flex items-center mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Pertanyaan Lain
            </button>

            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.survey.show', $survey->id) }}"
                   class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm
                          transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center bg-green-600 text-white font-bold py-2.5 px-6 rounded-lg shadow-md
                               hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2
                               transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Semua Pertanyaan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pertanyaanWrapper = document.getElementById('pertanyaan-wrapper');
        const tambahBtn = document.getElementById('tambah-pertanyaan');

        // Function to handle type change for a specific question block
        function handleTipeChange(selectElement) {
            const questionBlock = selectElement.closest('.pertanyaan');
            const opsiDiv = questionBlock.querySelector('.opsi-wrapper');
            const opsiInput = opsiDiv.querySelector('input[name="opsi[]"]');
            const tipe = selectElement.value;

            if (tipe === 'pilihan' || tipe === 'ganda') {
                opsiDiv.classList.remove('hidden');
                opsiInput.setAttribute('required', 'required'); // Make options required for these types
            } else {
                opsiDiv.classList.add('hidden');
                opsiInput.removeAttribute('required'); // Remove required for other types
                opsiInput.value = ''; // Clear options input when hidden
            }
        }

        // Initialize state for existing (first) question block on load
        pertanyaanWrapper.querySelectorAll('.tipe-select').forEach(handleTipeChange);

        // Add event listener for type changes within the wrapper
        pertanyaanWrapper.addEventListener('change', (e) => {
            if (e.target.classList.contains('tipe-select')) {
                handleTipeChange(e.target);
            }
        });

        // Add new question logic
        tambahBtn.addEventListener('click', () => {
            const originalQuestionBlock = pertanyaanWrapper.children[0];
            const clone = originalQuestionBlock.cloneNode(true);

            // Reset values and hide options wrapper for the cloned question
            clone.querySelectorAll('input').forEach(el => {
                el.value = ''; // Clear input text
                el.classList.remove('border-red-500'); // Clear error state
            });
            clone.querySelectorAll('select').forEach(el => {
                el.value = el.options[0].value; // Reset select to first option
                el.classList.remove('border-red-500'); // Clear error state
            });
            clone.querySelector('.opsi-wrapper').classList.add('hidden'); // Hide options wrapper
            clone.querySelector('.opsi-wrapper input[name="opsi[]"]').removeAttribute('required'); // Ensure cloned options are not required initially

            // Show delete button for cloned questions
            const deleteBtn = clone.querySelector('.delete-question-btn');
            if (deleteBtn) {
                deleteBtn.classList.remove('hidden');
                deleteBtn.onclick = () => {
                    clone.remove(); // Remove the cloned question block
                };
            }

            pertanyaanWrapper.appendChild(clone);
            clone.scrollIntoView({ behavior: 'smooth', block: 'end' }); // Scroll to the new question
        });

        // Re-attach event listeners to handle delete buttons on wrapper (delegation)
        pertanyaanWrapper.addEventListener('click', (e) => {
            if (e.target.closest('.delete-question-btn')) {
                e.target.closest('.pertanyaan').remove();
            }
        });

        // Initialize delete button for first item if it's the only one
        // (This won't usually be visible for the first question, but good for consistency)
        if (pertanyaanWrapper.children.length === 1) {
             const firstDeleteBtn = pertanyaanWrapper.children[0].querySelector('.delete-question-btn');
             if (firstDeleteBtn) {
                 firstDeleteBtn.classList.add('hidden'); // Ensure first one is hidden
             }
        }
    });
</script>
@endpush
@endsection