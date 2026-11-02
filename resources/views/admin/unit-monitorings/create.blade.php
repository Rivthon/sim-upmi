@extends('layouts.admin')

@section('title', 'Tambah Monev Unit')

@section('content')
<div class="mx-auto max-w-6xl">
    <form action="{{ route('admin.unit-monitorings.store') }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <h2 class="text-3xl font-extrabold text-slate-950">Tambah Monev Prodi / Unit</h2>
        <p class="mt-2 text-slate-600">Catat target, realisasi, analisis, bukti, dan tindak lanjut capaian unit.</p>
        <div class="mt-6">@include('admin.unit-monitorings._form')</div>
    </form>
</div>
@endsection
