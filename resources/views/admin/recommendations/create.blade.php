@extends('layouts.admin')

@section('title', 'Tambah Rekomendasi')

@section('content')
<div class="mx-auto max-w-6xl">
    <form action="{{ route('admin.recommendations.store') }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <h2 class="text-3xl font-extrabold text-slate-950">Tambah Rekomendasi</h2>
        <p class="mt-2 text-slate-600">Ubah hasil evaluasi menjadi daftar rekomendasi yang punya PIC, prioritas, dan deadline.</p>
        <div class="mt-6">@include('admin.recommendations._form')</div>
    </form>
</div>
@endsection
