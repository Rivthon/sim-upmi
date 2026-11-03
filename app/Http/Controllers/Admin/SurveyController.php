<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SurveyExport;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Survey;
use App\Models\SurveyTarget;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use QuickChart;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with('targets')->withCount(['questions', 'responses'])->latest()->get();

        return view('admin.survey.index', compact('surveys'));
    }

    public function create()
    {
        return view('admin.survey.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'target' => 'required|array',
            'target.*' => 'in:Umum,Prodi D3 Kebidanan,Prodi S1 Farmasi,Prodi S1 Gizi,Tendik,Mahasiswa',
            'is_public' => 'nullable|boolean',
            'is_aktif' => 'nullable|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $survey = Survey::create([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'is_public' => $request->boolean('is_public'),
            'is_aktif' => $request->boolean('is_aktif'),
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'public_token' => (string) Str::uuid(),
        ]);

        foreach ($data['target'] as $t) {
            SurveyTarget::create([
                'survey_id' => $survey->id,
                'target' => $t,
            ]);
        }

        ActivityLog::record('create', 'survey', $survey, [], [
            'judul' => $survey->judul,
            'deskripsi' => $survey->deskripsi,
            'target' => $data['target'],
            'is_public' => $survey->is_public,
            'starts_at' => $survey->starts_at,
            'ends_at' => $survey->ends_at,
        ]);

        return redirect()->route('admin.survey.index')->with('success', 'Survey berhasil dibuat');
    }

    public function show($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);

        return view('admin.survey.show', compact('survey'));
    }

    public function edit($id)
    {
        $survey = Survey::with('targets')->findOrFail($id);

        return view('admin.survey.edit', compact('survey'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'target' => 'required|array',
            'target.*' => 'in:Umum,Prodi D3 Kebidanan,Prodi S1 Farmasi,Prodi S1 Gizi,Tendik,Mahasiswa',
            'is_public' => 'nullable|boolean',
            'is_aktif' => 'nullable|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $survey = Survey::findOrFail($id);
        $before = [
            'judul' => $survey->judul,
            'deskripsi' => $survey->deskripsi,
            'target' => $survey->targets()->pluck('target')->values()->all(),
            'is_public' => $survey->is_public,
            'is_aktif' => $survey->is_aktif,
            'starts_at' => $survey->starts_at,
            'ends_at' => $survey->ends_at,
        ];

        $survey->update([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'is_public' => $request->boolean('is_public'),
            'is_aktif' => $request->boolean('is_aktif'),
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'public_token' => $survey->public_token ?: (string) Str::uuid(),
        ]);

        // Update target
        SurveyTarget::where('survey_id', $survey->id)->delete();
        foreach ($data['target'] as $t) {
            SurveyTarget::create([
                'survey_id' => $survey->id,
                'target' => $t,
            ]);
        }

        ActivityLog::record('update', 'survey', $survey, $before, [
            'judul' => $survey->judul,
            'deskripsi' => $survey->deskripsi,
            'target' => $data['target'],
            'is_public' => $survey->is_public,
            'is_aktif' => $survey->is_aktif,
            'starts_at' => $survey->starts_at,
            'ends_at' => $survey->ends_at,
        ]);

        return redirect()->route('admin.survey.index')->with('success', 'Survey berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);

        ActivityLog::record('delete', 'survey', $survey, [
            'judul' => $survey->judul,
            'deskripsi' => $survey->deskripsi,
            'target' => $survey->targets()->pluck('target')->values()->all(),
        ]);

        // Hapus survey (jika foreign key-nya sudah ON DELETE CASCADE maka relasi ikut kehapus)
        $survey->delete();

        return redirect()->route('admin.survey.index')->with('success', 'Survey berhasil dihapus.');
    }

    public function hasil($id)
    {
        // Muat survey dan pertanyaan beserta responnya
        $survey = Survey::with(['questions.responses'])->findOrFail($id);
        $questions = $survey->questions;

        // Hitung total responden
        $totalResponses = 0;
        if ($survey->questions->isNotEmpty() && $survey->questions->first()->responses->isNotEmpty()) {
            $totalResponses = $survey->questions->first()->responses->count();
            // Lebih akurat untuk menghitung responden unik:
            // $totalResponses = \App\Models\SurveyResponse::where('survey_id', $survey->id)->distinct('user_id')->count();
        }

        foreach ($questions as $q) {
            $q->result_counts = []; // Inisialisasi sebagai array kosong untuk menghindari error jika tidak ada data

            // Logika untuk tipe pertanyaan yang memerlukan grafik
            // Pastikan nama tipe ini konsisten dengan yang disimpan di database
            if ($q->tipe === 'skala') {
                $opsi_labels = ['1', '2', '3', '4', '5']; // Skala selalu 1-5
                $counts = array_fill_keys($opsi_labels, 0); // Inisialisasi hitungan untuk setiap angka 1-5

                foreach ($q->responses as $res) {
                    // Pastikan jawaban adalah angka skala yang valid dan tambahkan ke hitungan
                    $jawaban_num = (string) $res->jawaban; // Konversi ke string untuk konsistensi key
                    if (isset($counts[$jawaban_num])) {
                        $counts[$jawaban_num]++;
                    }
                }
                $q->result_counts = $counts;

            } elseif (in_array($q->tipe, ['pilihan', 'ganda'])) { // *** FIX INI *** Gunakan nama tipe yang konsisten
                // Dekode opsi dari JSON. Jika $q->opsi null/invalid, akan menjadi array kosong.
                $opsi = json_decode($q->opsi, true) ?? [];
                $counts = array_fill_keys($opsi, 0); // Inisialisasi hitungan untuk setiap opsi

                foreach ($q->responses as $res) {
                    // Jika tipe ganda, jawaban bisa berupa array JSON string. Jika tunggal, string biasa.
                    $jawaban = ($q->tipe === 'ganda')
                        ? (is_array(json_decode($res->jawaban, true)) ? json_decode($res->jawaban, true) : [])
                        : [$res->jawaban]; // Masukkan jawaban tunggal ke dalam array agar iterasi konsisten

                    foreach ($jawaban as $j) {
                        if (isset($counts[$j])) {
                            $counts[$j]++;
                        }
                    }
                }
                $q->result_counts = $counts;
            }
            // Tipe 'text' tidak memerlukan result_counts, jawabannya ditampilkan mentah di Blade
        }

        // Kirim $totalResponses ke view
        return view('admin.survey.hasil', compact('survey', 'questions', 'totalResponses'));
    }

    public function export($id)
    {
        $survey = Survey::with('questions.responses.user')->findOrFail($id);
        $fileName = 'Hasil_Survei_'.str_replace(' ', '_', $survey->judul).'.xlsx';

        ActivityLog::record('export', 'survey', $survey, [], [
            'judul' => $survey->judul,
            'format' => 'xlsx',
        ]);

        return Excel::download(new SurveyExport($survey), $fileName);
    }

    public function exportPdf($id)
    {
        $survey = Survey::with('questions.responses.user')->findOrFail($id);

        ActivityLog::record('export', 'survey', $survey, [], [
            'judul' => $survey->judul,
            'format' => 'pdf',
        ]);

        // Generate chart untuk setiap pertanyaan (harus sebelum render view)
        foreach ($survey->questions as $q) {
            if (in_array($q->tipe, ['pilihan', 'ganda'])) {
                $opsi = json_decode($q->opsi, true) ?? [];
                $counts = array_fill_keys($opsi, 0);

                foreach ($q->responses as $res) {
                    $jawaban = $q->tipe === 'ganda'
                        ? json_decode($res->jawaban, true) ?? []
                        : [$res->jawaban];

                    foreach ($jawaban as $j) {
                        if (isset($counts[$j])) {
                            $counts[$j]++;
                        }
                    }
                }

                // Simpan untuk grafik dan presentase
                $q->result_counts = $counts;
                $q->chartImage = $this->generateChartImage(array_keys($counts), array_values($counts));
            }
        }

        // Baru render ke PDF setelah chart disiapkan
        return Pdf::loadView('admin.survey.export_pdf', compact('survey'))
            ->setPaper('a4', 'portrait')
            ->download('Hasil_Survei_'.str_replace(' ', '_', $survey->judul).'.pdf');
    }

    private function generateChartImage($labels, $data)
    {
        $chart = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Jumlah Jawaban',
                    'data' => $data,
                    'backgroundColor' => '#3B82F6',
                ]],
            ],
            'options' => [
                'scales' => [
                    'y' => ['beginAtZero' => true],
                ],
            ],
        ];

        $chartUrl = 'https://quickchart.io/chart?c='.urlencode(json_encode($chart));

        // Ambil base64 image dari QuickChart
        $imageData = file_get_contents('https://quickchart.io/chart?c='.urlencode(json_encode($chart)));

        return 'data:image/png;base64,'.base64_encode($imageData);
    }
}
