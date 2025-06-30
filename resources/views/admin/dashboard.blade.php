@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-white shadow rounded-xl p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard Admin UPMI</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-blue-100 p-4 rounded-lg shadow">
        <h2 class="text-lg font-bold text-blue-700">Total Dokumen Mutu</h2>
        <p class="text-3xl mt-2 text-blue-900 font-semibold">{{ $totalDokumen }}</p>
    </div>

    <div class="bg-green-100 p-4 rounded-lg shadow">
        <h2 class="text-lg font-bold text-green-700">Audit Terjadwal</h2>
        <p class="text-3xl mt-2 text-green-900 font-semibold">{{ $auditTerjadwal }}</p>
    </div>

    <div class="bg-yellow-100 p-4 rounded-lg shadow">
        <h2 class="text-lg font-bold text-yellow-700">Temuan Belum Ditindaklanjuti</h2>
        <p class="text-3xl mt-2 text-yellow-900 font-semibold">{{ $temuanBelumDitindak }}</p>
    </div>
</div>


        <!-- <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-700 mb-2">Informasi Terkini</h3>
            <ul class="list-disc pl-6 text-gray-600">
                <li>Audit Internal akan dimulai 1 Juli 2025.</li>
                <li>Deadline pengumpulan borang prodi: 25 Juni 2025.</li>
                <li>Survei mahasiswa aktif hingga 20 Juni 2025.</li>
            </ul>
        </div> -->
    </div>
</div>
@endsection
