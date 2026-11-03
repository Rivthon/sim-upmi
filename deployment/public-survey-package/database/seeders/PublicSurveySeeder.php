<?php

namespace Database\Seeders;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyTarget;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PublicSurveySeeder extends Seeder
{
    public function run(): void
    {
        $surveys = [
            'Survei Kepuasan Layanan Akademik dan Nonakademik' => [
                'deskripsi' => 'Evaluasi pengalaman civitas terhadap layanan akademik dan layanan pendukung kampus.',
                'questions' => [
                    'Informasi layanan akademik disampaikan dengan jelas.',
                    'Petugas memberikan pelayanan dengan ramah dan responsif.',
                    'Proses administrasi akademik mudah dipahami.',
                    'Layanan nonakademik membantu kebutuhan civitas kampus.',
                    'Secara keseluruhan saya puas terhadap layanan kampus.',
                ],
            ],
            'Survei Kepuasan Manajemen dan Tata Kelola' => [
                'deskripsi' => 'Evaluasi transparansi, komunikasi, kepemimpinan, dan tata kelola institusi.',
                'questions' => [
                    'Kebijakan institusi disampaikan secara transparan.',
                    'Pimpinan menindaklanjuti masukan dari civitas kampus.',
                    'Koordinasi antarunit berjalan efektif.',
                    'Pengambilan keputusan dilakukan secara akuntabel.',
                    'Secara keseluruhan saya puas terhadap tata kelola institusi.',
                ],
            ],
            'Survei Kepuasan Sarana dan Prasarana' => [
                'deskripsi' => 'Evaluasi kenyamanan, kelayakan, kebersihan, dan aksesibilitas fasilitas kampus.',
                'questions' => [
                    'Ruang pembelajaran nyaman dan layak digunakan.',
                    'Fasilitas teknologi mendukung kegiatan akademik.',
                    'Kebersihan lingkungan kampus terjaga.',
                    'Sarana pendukung mudah diakses saat dibutuhkan.',
                    'Secara keseluruhan saya puas terhadap sarana dan prasarana.',
                ],
            ],
        ];

        foreach ($surveys as $title => $config) {
            $survey = Survey::updateOrCreate(
                ['judul' => $title],
                [
                    'deskripsi' => $config['deskripsi'],
                    'is_aktif' => true,
                    'is_public' => true,
                    'public_token' => Survey::where('judul', $title)->value('public_token') ?: (string) Str::uuid(),
                    'starts_at' => now(),
                    'ends_at' => now()->addDays(2),
                ]
            );

            SurveyTarget::firstOrCreate(['survey_id' => $survey->id, 'target' => 'Umum']);

            foreach ($config['questions'] as $question) {
                SurveyQuestion::firstOrCreate(
                    ['survey_id' => $survey->id, 'pertanyaan' => $question],
                    ['tipe' => 'skala', 'opsi' => null]
                );
            }

            SurveyQuestion::firstOrCreate(
                ['survey_id' => $survey->id, 'pertanyaan' => 'Saran dan masukan untuk perbaikan layanan.'],
                ['tipe' => 'teks', 'opsi' => null]
            );
        }
    }
}
