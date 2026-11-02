@extends('layouts.admin')

@section('title', 'Edit Rekomendasi')

@section('content')
<div class="mx-auto max-w-6xl">
    <form action="{{ route('admin.recommendations.update', $recommendation) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        @method('PUT')
        <h2 class="text-3xl font-extrabold text-slate-950">Edit Rekomendasi</h2>
        <p class="mt-2 text-slate-600">Perbarui status, tindak lanjut, atau prioritas rekomendasi.</p>
        <div class="mt-6">@include('admin.recommendations._form')</div>
    </form>
</div>
@endsection
