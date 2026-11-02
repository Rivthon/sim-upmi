@extends('layouts.admin')

@section('title', 'Tambah Risiko Mutu')

@section('content')
<div class="mx-auto max-w-5xl">
    <form action="{{ route('admin.quality-risks.store') }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <h2 class="text-3xl font-extrabold text-slate-950">Tambah Risiko Mutu</h2>
        <p class="mt-2 text-slate-600">Catat risiko, skor, mitigasi, PIC, dan status penanganannya.</p>
        <div class="mt-6">@include('admin.quality-risks._form')</div>
    </form>
</div>
@endsection
