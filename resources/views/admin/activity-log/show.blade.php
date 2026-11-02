@extends('layouts.admin')

@section('title', 'Detail Audit Trail')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="bg-blue-600 text-white p-5 flex justify-between items-center">
            <h1 class="text-2xl font-extrabold">Detail Audit Trail</h1>
            <a href="{{ route('admin.activity-log.index') }}" class="px-4 py-2 bg-white text-blue-700 rounded-md font-semibold">Kembali</a>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm uppercase font-semibold text-gray-500">Waktu</p>
                <p class="text-lg text-gray-900">{{ $activityLog->created_at->format('d F Y H:i:s') }}</p>
            </div>
            <div>
                <p class="text-sm uppercase font-semibold text-gray-500">User</p>
                <p class="text-lg text-gray-900">{{ $activityLog->user->name ?? 'System' }}</p>
            </div>
            <div>
                <p class="text-sm uppercase font-semibold text-gray-500">Modul</p>
                <p class="text-lg text-gray-900">{{ $activityLog->module ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm uppercase font-semibold text-gray-500">Aksi</p>
                <p class="text-lg text-gray-900">{{ $activityLog->action }}</p>
            </div>
            <div>
                <p class="text-sm uppercase font-semibold text-gray-500">Target</p>
                <p class="text-lg text-gray-900">{{ class_basename($activityLog->subject_type) ?: '-' }} #{{ $activityLog->subject_id ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm uppercase font-semibold text-gray-500">IP Address</p>
                <p class="text-lg text-gray-900">{{ $activityLog->ip_address ?? '-' }}</p>
            </div>
        </div>

        <div class="px-6 pb-6 space-y-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-2">Data Sebelum</h2>
                <pre class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto text-sm">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-2">Data Sesudah</h2>
                <pre class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto text-sm">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-2">User Agent</h2>
                <p class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700 break-words">{{ $activityLog->user_agent ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
