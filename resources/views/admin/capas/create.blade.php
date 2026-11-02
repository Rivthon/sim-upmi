@extends('layouts.admin')
@section('title', 'Tambah CAPA')
@section('content')
<div class="mx-auto max-w-5xl"><form action="{{ route('admin.capas.store') }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8"><h2 class="text-3xl font-extrabold text-slate-950">Tambah CAPA</h2><div class="mt-6">@include('admin.capas._form')</div></form></div>
@endsection
