@extends('layouts.user')

@section('title', 'Daftar Survei Kepuasan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Survei Kepuasan</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($surveys->count() > 0)
        <div class="grid gap-6">
            @foreach($surveys as $survey)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $survey->judul }}</h3>
                    <p class="text-gray-600 mt-1">{{ $survey->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                    {{-- Tampilkan status pengisian jika tersedia --}}
                    @if($survey->sudah_isi)
                        <p class="mt-4 text-green-600 font-medium">Anda sudah mengisi survei ini.</p>
                    @else
                        <a href="{{ route('user.survey.fill', $survey->id) }}"
                           class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                            Isi Survei
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Tidak ada survei yang tersedia untuk Anda saat ini.</p>
    @endif
</div>
@endsection
