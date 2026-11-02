@extends('layouts.admin')
@section('title', 'Edit CAPA')
@section('content')
<div class="mx-auto max-w-5xl"><form action="{{ route('admin.capas.update', $capa) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">@method('PUT')<h2 class="text-3xl font-extrabold text-slate-950">Edit CAPA</h2><div class="mt-6">@include('admin.capas._form')</div></form></div>
@endsection
