@extends('layouts.admin')

@section('title', 'Edit Risiko Mutu')

@section('content')
<div class="mx-auto max-w-5xl">
    <form action="{{ route('admin.quality-risks.update', $risk) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        @method('PUT')
        <h2 class="text-3xl font-extrabold text-slate-950">Edit Risiko Mutu</h2>
        <p class="mt-2 text-slate-600">Perbarui skor risiko dan strategi mitigasinya.</p>
        <div class="mt-6">@include('admin.quality-risks._form')</div>
    </form>
</div>
@endsection
