@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Edit Jadwal AMI</h2>
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
    <form action="{{ route('admin.ami.update', $jadwalAmi->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Tahun --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tahun</label>
            <input type="number" name="tahun" value="{{ old('tahun', $jadwalAmi->tahun) }}" class="w-full border rounded p-2">
        </div>

        {{-- Judul --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $jadwalAmi->judul) }}" class="w-full border rounded p-2">
        </div>

        {{-- Unit --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Unit</label>
            <select name="unit" id="unit" class="w-full border rounded p-2">
                <option value="">Pilih Unit</option>
                <option value="Prodi D3 Kebidanan" {{ $jadwalAmi->unit == 'Prodi D3 Kebidanan' ? 'selected' : '' }}>Prodi D3 Kebidanan</option>
                <option value="Prodi S1 Farmasi" {{ $jadwalAmi->unit == 'Prodi S1 Farmasi' ? 'selected' : '' }}>Prodi S1 Farmasi</option>
                <option value="Prodi S1 Gizi" {{ $jadwalAmi->unit == 'Prodi S1 Gizi' ? 'selected' : '' }}>Prodi S1 Gizi</option>
                <option value="Tendik" {{ $jadwalAmi->unit == 'Tendik' ? 'selected' : '' }}>Tendik</option>
            </select>
        </div>

        {{-- Sub Unit (Muncul jika pilih Tendik) --}}
        <div class="mb-4 {{ $jadwalAmi->unit == 'Tendik' ? '' : 'hidden' }}" id="sub-unit-wrapper">
            <label class="block text-sm font-medium text-gray-700">Sub Unit</label>
            <select name="sub_unit" id="sub_unit" class="w-full border rounded p-2">
                <option value="">Pilih Sub Unit</option>
                @foreach(['Laboran Farmasi','Laboran Gizi','Laboran Bidan','Perpustakaan','ICT','BAAK','OPERATOR','BAUK','SARPRAS','SDM','KERJASAMA','HUMAS','KEMAHASISWAAN'] as $sub)
                    <option value="{{ $sub }}" {{ $jadwalAmi->sub_unit == $sub ? 'selected' : '' }}>{{ $sub }}</option>
                @endforeach
            </select>
        </div>
{{-- Auditor --}}
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Tim Auditor</label>
    <div class="grid grid-cols-2 gap-2">
        @foreach ($auditors as $auditor)
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="auditors[]" value="{{ $auditor->id }}"
                    {{ in_array($auditor->id, old('auditors', $jadwalAmi->auditors->pluck('id')->toArray())) ? 'checked' : '' }}>
                <span>{{ $auditor->name }}</span>
            </label>
        @endforeach
    </div>
</div>

        {{-- Jadwal Mulai --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $jadwalAmi->tanggal_mulai) }}" class="w-full border rounded p-2">
        </div>

        {{-- Jadwal Selesai --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $jadwalAmi->tanggal_selesai) }}" class="w-full border rounded p-2">
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full border rounded p-2">{{ old('deskripsi', $jadwalAmi->deskripsi) }}</textarea>
        </div>

        {{-- Status --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="Draft" {{ $jadwalAmi->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Final" {{ $jadwalAmi->status == 'Final' ? 'selected' : '' }}>Final</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Update
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitSelect = document.getElementById('unit');
    const subUnitWrapper = document.getElementById('sub-unit-wrapper');

    function toggleSubUnit() {
        if (unitSelect.value === 'Tendik') {
            subUnitWrapper.classList.remove('hidden');
        } else {
            subUnitWrapper.classList.add('hidden');
            document.getElementById('sub_unit').value = '';
        }
    }

    unitSelect.addEventListener('change', toggleSubUnit);
    toggleSubUnit(); // run once on load
});
</script>
@endpush
