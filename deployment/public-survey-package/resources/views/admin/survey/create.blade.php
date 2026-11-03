@extends('layouts.admin')

@section('title', 'Buat Survey')

@section('content')
<div class="mx-auto max-w-5xl">
    <form action="{{ route('admin.survey.store') }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Survey</p>
        <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Buat Survey Baru</h2>
        <p class="mt-2 text-slate-600">Atur target, akses publik, dan periode pengisian survey.</p>
        <div class="mt-7">@include('admin.survey._form', ['survey' => null])</div>
    </form>
</div>
@endsection
