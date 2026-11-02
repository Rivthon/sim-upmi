@extends('layouts.admin')

@section('title', 'Hasil Survei: ' . $survey->judul)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 pb-4">Hasil Survei: <span class="text-blue-600">{{ $survey->judul }}</span></h2>

        {{-- Detail Ringkas Survei --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-base mb-8">
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Total Responden</p>
                <p class="text-gray-900 text-lg font-medium">{{ $totalResponses ?? 0 }}</p>
            </div>
            <div>
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Status Survei</p>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-base font-semibold leading-tight
                    {{ $survey->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($survey->status) }}
                </span>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 font-semibold text-sm uppercase mb-1">Target Survei</p>
                <div class="flex flex-wrap gap-2 mt-2">
                    @forelse($survey->targets as $target)
                        <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full shadow-sm">
                            {{ ucfirst($target->target) }}
                        </span>
                    @empty
                        <p class="text-gray-500 italic text-lg">Tidak ada target.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- List Pertanyaan dan Hasilnya --}}
        <h3 class="text-2xl font-bold text-gray-800 mb-6 border-t-2 pt-4 mt-8 pb-4">Analisis Pertanyaan</h3>
        
        @forelse ($questions as $index => $question)
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-8 transition-transform duration-200 hover:shadow-lg">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100">
                    Pertanyaan {{ $index + 1 }}: {{ $question->pertanyaan }}
                </h3>

                {{-- Pastikan nama tipe konsisten dengan controller: pilihan_tunggal, pilihan_ganda, skala --}}
                @if (in_array($question->tipe, ['pilihan', 'ganda', 'skala'])) {{-- Perbaikan di sini --}}
                    {{-- Render chart only if there is data --}}
                    @if ($question->result_counts && count($question->result_counts) > 0)
                        <div class="chart-container relative" style="height:300px; width:100%;">
                            <canvas id="chart-{{ $question->id }}" class="w-full h-full"></canvas> {{-- Added w-full h-full --}}
                        </div>
                        {{-- Script Chart.js untuk setiap pertanyaan --}}
                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const ctx = document.getElementById('chart-{{ $question->id }}');
                                // Hanya inisialisasi jika elemen ada dan belum ada Chart instance
                                if (ctx && !Chart.getChart(ctx)) { 
                                    new Chart(ctx.getContext('2d'), {
                                        type: 'bar',
                                        data: {
                                            labels: @json(array_keys($question->result_counts ?? [])),
                                            datasets: [{
                                                label: 'Jumlah Jawaban',
                                                data: @json(array_values($question->result_counts ?? [])),
                                                backgroundColor: [
                                                    'rgba(59, 130, 246, 0.8)', // blue-500
                                                    'rgba(168, 85, 247, 0.8)', // purple-500
                                                    'rgba(34, 197, 94, 0.8)',  // green-500
                                                    'rgba(251, 191, 36, 0.8)', // yellow-500
                                                    'rgba(239, 68, 68, 0.8)',   // red-500
                                                    'rgba(249, 115, 22, 0.8)',  // orange-500
                                                    'rgba(236, 72, 153, 0.8)'   // pink-500
                                                ],
                                                borderColor: [
                                                    'rgba(59, 130, 246, 1)',
                                                    'rgba(168, 85, 247, 1)',
                                                    'rgba(34, 197, 94, 1)',
                                                    'rgba(251, 191, 36, 1)',
                                                    'rgba(239, 68, 68, 1)',
                                                    'rgba(249, 115, 22, 1)',
                                                    'rgba(236, 72, 153, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false, // Memungkinkan tinggi diatur oleh CSS
                                            plugins: {
                                                legend: { display: false },
                                                title: { display: false },
                                                tooltip: {
                                                    callbacks: {
                                                        label: function(context) {
                                                            let label = context.dataset.label || '';
                                                            if (label) {
                                                                label += ': ';
                                                            }
                                                            if (context.parsed.y !== null) {
                                                                label += context.parsed.y;
                                                                const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                                                const percentage = total > 0 ? ((context.parsed.y / total) * 100).toFixed(1) + '%' : '0%';
                                                                label += ` (${percentage})`;
                                                            }
                                                            return label;
                                                        }
                                                    }
                                                }
                                            },
                                            scales: {
                                                x: {
                                                    grid: {
                                                        display: false
                                                    },
                                                    ticks: {
                                                        color: '#4A5568', // text-gray-700 - Set font color for x-axis ticks
                                                        font: {
                                                            size: 12
                                                        }
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        stepSize: 1, // Memastikan langkah integer
                                                        color: '#4A5568', // text-gray-700 - Set font color for y-axis ticks
                                                        font: {
                                                            size: 12
                                                        },
                                                        callback: function(value) {if (value % 1 === 0) return value;} // Menampilkan hanya ticks integer
                                                    },
                                                    grid: {
                                                        color: 'rgba(200, 200, 200, 0.2)' // Garis grid terang
                                                    }
                                                }
                                            }
                                        }
                                    });
                                }
                            });
                        </script>
                        @endpush
                    @else
                        <div class="mt-4 p-4 text-center bg-gray-100 rounded-lg border border-gray-200">
                            <p class="text-gray-500 italic">Belum ada data respons untuk grafik pertanyaan ini.</p>
                        </div>
                    @endif
                {{-- Pastikan nama tipe konsisten: 'text' --}}
                @elseif ($question->tipe == 'teks') 
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="font-semibold text-gray-700 mb-2">Jawaban Responden:</p>
                        @forelse ($question->responses as $res)
                            <div class="mb-2 pb-2 border-b border-gray-100 last:border-b-0 last:mb-0 last:pb-0">
                                <p class="text-gray-800 text-base leading-relaxed">{{ $res->jawaban }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">Belum ada jawaban teks untuk pertanyaan ini.</p>
                        @endforelse
                    </div>
                @endif
            </div>
        @empty
            <div class="p-6 text-center bg-gray-50 rounded-xl shadow-sm border border-gray-200">
                <p class="text-gray-600 text-lg italic">Belum ada pertanyaan atau respon untuk survei ini.</p>
            </div>
        @endforelse

<div class="flex space-x-3 mb-6">
    <a href="{{ route('admin.survey.export', $survey->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm font-semibold">
        📊 Export Excel
    </a>
    <a href="{{ route('admin.survey.export.pdf', $survey->id) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow text-sm font-semibold">
        🧾 Export PDF
    </a>
</div>



        {{-- Tombol Kembali --}}
        <div class="flex justify-start mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.survey.index') }}" 
               class="inline-flex items-center px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Survei
            </a>
        </div>
    </div>
</div>

{{-- Pastikan Chart.js CDN dimuat di layout admin Anda (contoh di layouts/admin.blade.php): --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

{{-- Dan pastikan ada @stack('scripts') di layouts/admin.blade.php, biasanya sebelum </body> penutup --}}
@endsection
