@extends('layouts.admin') {{-- sesuaikan jika pakai layout lain --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Buat Jadwal AMI</h2>
        
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
        
        <form action="{{ route('admin.ami.store') }}" method="POST">
            @csrf

            {{-- Tahun --}}
            <div class="mb-5">
                <label for="tahun" class="block text-gray-700 text-sm font-semibold mb-2">Tahun</label>
                <input type="number" id="tahun" name="tahun" value="{{ old('tahun') }}" 
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('tahun') border-red-500 @enderror" required>
                @error('tahun') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
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

            {{-- Unit --}}
            <div class="mb-5">
                <label for="unit" class="block text-gray-700 text-sm font-semibold mb-2">Unit</label>
                <select name="unit" id="unit" 
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('unit') border-red-500 @enderror" required>
                    <option value="">Pilih Unit</option>
                    <option value="Prodi D3 Kebidanan" {{ old('unit') == 'Prodi D3 Kebidanan' ? 'selected' : '' }}>Prodi D3 Kebidanan</option>
                    <option value="Prodi S1 Farmasi" {{ old('unit') == 'Prodi S1 Farmasi' ? 'selected' : '' }}>Prodi S1 Farmasi</option>
                    <option value="Prodi S1 Gizi" {{ old('unit') == 'Prodi S1 Gizi' ? 'selected' : '' }}>Prodi S1 Gizi</option>
                    <option value="Tendik" {{ old('unit') == 'Tendik' ? 'selected' : '' }}>Tendik</option>
                </select>
                @error('unit') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Sub Unit Tendik (muncul jika pilih Tendik) --}}
            <div class="mb-5 {{ old('unit') == 'Tendik' ? '' : 'hidden' }}" id="sub-unit-wrapper">
                <label for="sub_unit" class="block text-gray-700 text-sm font-semibold mb-2">Sub Unit</label>
                <select name="sub_unit" id="sub_unit" 
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('sub_unit') border-red-500 @enderror">
                    <option value="">Pilih Sub Unit</option>
                    <option value="Laboran Farmasi" {{ old('sub_unit') == 'Laboran Farmasi' ? 'selected' : '' }}>Laboran Farmasi</option>
                    <option value="Laboran Gizi" {{ old('sub_unit') == 'Laboran Gizi' ? 'selected' : '' }}>Laboran Gizi</option>
                    <option value="Laboran Bidan" {{ old('sub_unit') == 'Laboran Bidan' ? 'selected' : '' }}>Laboran Bidan</option>
                    <option value="Perpustakaan" {{ old('sub_unit') == 'Perpustakaan' ? 'selected' : '' }}>Perpustakaan</option>
                    <option value="ICT" {{ old('sub_unit') == 'ICT' ? 'selected' : '' }}>ICT</option>
                    <option value="BAAK" {{ old('sub_unit') == 'BAAK' ? 'selected' : '' }}>BAAK</option>
                    <option value="OPERATOR" {{ old('sub_unit') == 'OPERATOR' ? 'selected' : '' }}>OPERATOR</option>
                    <option value="BAUK" {{ old('sub_unit') == 'BAUK' ? 'selected' : '' }}>BAUK</option>
                    <option value="SARPRAS" {{ old('sub_unit') == 'SARPRAS' ? 'selected' : '' }}>SARPRAS</option>
                    <option value="SDM" {{ old('sub_unit') == 'SDM' ? 'selected' : '' }}>SDM</option>
                    <option value="KERJASAMA" {{ old('sub_unit') == 'KERJASAMA' ? 'selected' : '' }}>KERJASAMA</option>
                    <option value="HUMAS" {{ old('sub_unit') == 'HUMAS' ? 'selected' : '' }}>HUMAS</option>
                    <option value="KEMAHASISWAAN" {{ old('sub_unit') == 'KEMAHASISWAAN' ? 'selected' : '' }}>KEMAHASISWAAN</option>
                </select>
                @error('sub_unit') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tim Auditor --}}
            <div class="mb-5">
                <label for="auditors" class="block text-gray-700 text-sm font-semibold mb-2">Tim Auditor</label>
                <select name="auditors[]" id="auditors" multiple 
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('auditors') border-red-500 @enderror">
                    @foreach ($auditors as $auditor)
                        <option value="{{ $auditor->id }}" {{ (collect(old('auditors'))->contains($auditor->id)) ? 'selected' : '' }}>
                            {{ $auditor->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-2">* Tekan Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu.</p>
                @error('auditors') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jadwal Mulai --}}
            <div class="mb-5">
                <label for="tanggal_mulai" class="block text-gray-700 text-sm font-semibold mb-2">Jadwal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" 
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('tanggal_mulai') border-red-500 @enderror" required>
                @error('tanggal_mulai') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jadwal Selesai --}}
            <div class="mb-5">
                <label for="tanggal_selesai" class="block text-gray-700 text-sm font-semibold mb-2">Jadwal Selesai</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" 
                       class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                              transition duration-200 @error('tanggal_selesai') border-red-500 @enderror" required>
                @error('tanggal_selesai') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
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

            {{-- Status --}}
            <div class="mb-6">
                <label for="status" class="block text-gray-700 text-sm font-semibold mb-2">Status</label>
                <select name="status" id="status" 
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               transition duration-200 @error('status') border-red-500 @enderror" required>
                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-md
                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition duration-300 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg">
                    Simpan Jadwal AMI
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitSelect = document.getElementById('unit');
    const subUnitWrapper = document.getElementById('sub-unit-wrapper');
    const subUnitSelect = document.getElementById('sub_unit'); // Get the sub_unit select element

    function toggleSubUnit() {
        if (unitSelect.value === 'Tendik') {
            subUnitWrapper.classList.remove('hidden');
            // Make sub_unit required when visible, optional otherwise (Laravel validation will handle it)
            subUnitSelect.setAttribute('required', 'required');
        } else {
            subUnitWrapper.classList.add('hidden');
            subUnitSelect.value = ''; // Reset sub_unit value
            subUnitSelect.removeAttribute('required'); // Remove required attribute
        }
    }

    unitSelect.addEventListener('change', toggleSubUnit);
    toggleSubUnit(); // Trigger on page load to set initial state correctly based on old('unit')
});
</script>
@endpush
@endsection