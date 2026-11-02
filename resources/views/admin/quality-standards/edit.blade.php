@extends('layouts.admin')

@section('title', 'Edit Standar Mutu')

@section('content')
<div class="mx-auto max-w-4xl">
    <form action="{{ route('admin.quality-standards.update', $standard) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        @method('PUT')
        <h2 class="text-3xl font-extrabold text-slate-950">Edit Standar Mutu</h2>
        <div class="mt-6">@include('admin.quality-standards._form')</div>
    </form>
</div>
@endsection
