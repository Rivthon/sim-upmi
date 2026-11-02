@extends('layouts.admin')
@section('title', 'Edit Agenda Mutu')
@section('content')
<div class="mx-auto max-w-4xl"><form action="{{ route('admin.quality-calendars.update', $calendar) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">@method('PUT')<h2 class="text-3xl font-extrabold text-slate-950">Edit Agenda Mutu</h2><div class="mt-6">@include('admin.quality-calendars._form')</div></form></div>
@endsection
