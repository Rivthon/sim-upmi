@extends('layouts.admin')

@section('content')
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">
    <h2 class="text-xl font-bold mb-6">Tambah User Baru</h2>

    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="mb-4">
<label class="block font-medium text-sm text-gray-700 mb-2">Role</label>
@foreach ($roles as $role)
    <label class="inline-flex items-center mr-4">
        <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="rounded border-gray-300">
        <span class="ml-2 text-sm">{{ $role->name }}</span>
    </label>
@endforeach

        </div>

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700">Unit (Prodi / Tendik)</label>
    <select name="unit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        <option value="">-- Pilih Unit --</option>
        @foreach ($units as $unit)
            <option value="{{ $unit }}">{{ $unit }}</option>
        @endforeach
    </select>
</div>
<!-- Password -->
<div>
    <label>Password</label>
    <input type="password" name="password" class="input" required>
</div>



        <div class="flex justify-end">
            <a href="{{ route('admin.user.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded mr-2">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
