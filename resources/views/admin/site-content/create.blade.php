@extends('layouts.admin')

@section('title', 'Tambah Konten Web')

@section('content')
<div class="mx-auto max-w-4xl">
    <form action="{{ route('admin.site-content.store') }}" method="POST" enctype="multipart/form-data" class="admin-glass rounded-[1.75rem] p-6 md:p-8">
        <div class="mb-6">
            <p class="text-sm font-extrabold uppercase tracking-[0.2em] text-teal-700">Edit Web</p>
            <h2 class="mt-2 text-3xl font-extrabold text-slate-950">Tambah Konten Frontend</h2>
        </div>
        @include('admin.site-content._form')
    </form>
</div>
@endsection
