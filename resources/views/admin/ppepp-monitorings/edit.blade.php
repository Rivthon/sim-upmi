@extends('layouts.admin')
@section('title', 'Edit Monitoring PPEPP')
@section('content')
<div class="mx-auto max-w-5xl"><form action="{{ route('admin.ppepp-monitorings.update', $monitoring) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">@method('PUT')<h2 class="text-3xl font-extrabold text-slate-950">Edit Monitoring PPEPP</h2><div class="mt-6">@include('admin.ppepp-monitorings._form')</div></form></div>
@endsection
