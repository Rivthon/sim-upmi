@extends('layouts.admin')

@section('title', 'Audit Trail')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">Audit Trail</h1>
            <p class="text-sm text-gray-500 mt-1">Riwayat aktivitas penting di sistem.</p>
        </div>
    </div>

    <form method="GET" class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="module" class="block text-sm font-semibold text-gray-700 mb-1">Modul</label>
            <select name="module" id="module" class="w-full rounded-md border-gray-300">
                <option value="">Semua</option>
                @foreach ($modules as $module)
                    <option value="{{ $module }}" @selected(request('module') === $module)>{{ $module }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="action" class="block text-sm font-semibold text-gray-700 mb-1">Aksi</label>
            <select name="action" id="action" class="w-full rounded-md border-gray-300">
                <option value="">Semua</option>
                @foreach ($actions as $action)
                    <option value="{{ $action }}" @selected(request('action') === $action)>{{ $action }}</option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2 flex items-end gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md">Filter</button>
            <a href="{{ route('admin.activity-log.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-md">Reset</a>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Modul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Target</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Detail</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $log->user->name ?? 'System' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $log->module ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">{{ $log->action }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ class_basename($log->subject_type) ?: '-' }} #{{ $log->subject_id ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('admin.activity-log.show', $log) }}" class="text-blue-600 hover:underline font-semibold">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada aktivitas tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
