@extends('layouts.admin')

@section('title', 'Edit Akreditasi')

@section('content')
<div class="mx-auto max-w-6xl">
    <form action="{{ route('admin.accreditations.update', $accreditation) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        @method('PUT')
        <h2 class="text-3xl font-extrabold text-slate-950">Edit Akreditasi</h2>
        <p class="mt-2 text-slate-600">Perbarui progres dan status kesiapan akreditasi.</p>
        <div class="mt-6">@include('admin.accreditations._form')</div>
    </form>
</div>
@endsection
