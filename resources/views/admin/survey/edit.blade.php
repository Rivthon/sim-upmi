@extends('layouts.admin')

@section('title', 'Edit Survey')

@section('content')
<div class="mx-auto max-w-5xl">
    <form action="{{ route('admin.survey.update', $survey) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        @method('PUT')
        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Survey</p>
        <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Edit Survey</h2>
        <p class="mt-2 text-slate-600">Perbarui masa aktif dan pengaturan link publik.</p>
        <div class="mt-7">@include('admin.survey._form')</div>
    </form>
</div>
@endsection
