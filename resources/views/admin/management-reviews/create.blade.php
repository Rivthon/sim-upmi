@extends('layouts.admin')
@section('title', 'Tambah RTM')
@section('content')
<div class="mx-auto max-w-5xl"><form action="{{ route('admin.management-reviews.store') }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8"><h2 class="text-3xl font-extrabold text-slate-950">Tambah RTM</h2><div class="mt-6">@include('admin.management-reviews._form')</div></form></div>
@endsection
