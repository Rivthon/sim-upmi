@extends('layouts.admin')

@section('title', 'Tambah Akreditasi')

@section('content')
<div class="mx-auto max-w-6xl">
    <form action="{{ route('admin.accreditations.store') }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <h2 class="text-3xl font-extrabold text-slate-950">Tambah Akreditasi</h2>
        <p class="mt-2 text-slate-600">Pantau status akreditasi, progress dokumen, tanggal asesmen, dan masa berlaku.</p>
        <div class="mt-6">@include('admin.accreditations._form')</div>
    </form>
</div>
@endsection
