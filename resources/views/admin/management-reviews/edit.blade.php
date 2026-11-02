@extends('layouts.admin')
@section('title', 'Edit RTM')
@section('content')
<div class="mx-auto max-w-5xl"><form action="{{ route('admin.management-reviews.update', $review) }}" method="POST" class="admin-glass rounded-[1.75rem] p-6 md:p-8">@method('PUT')<h2 class="text-3xl font-extrabold text-slate-950">Edit RTM</h2><div class="mt-6">@include('admin.management-reviews._form')</div></form></div>
@endsection
