@extends('layouts.admin')

@section('title', 'Tambah Standar Mutu')

@section('content')
<div class="mx-auto max-w-4xl">
    <form action="{{ route('admin.quality-standards.store') }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <h2 class="text-3xl font-extrabold text-slate-950">Tambah Standar Mutu</h2>
        <div class="mt-6">@include('admin.quality-standards._form')</div>
    </form>
</div>
@endsection
