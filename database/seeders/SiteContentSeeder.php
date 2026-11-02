<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            [
                'section' => 'hero',
                'key' => 'hero-main',
                'subtitle' => 'Sistem Penjaminan Mutu Internal',
                'title' => 'Budaya mutu yang transparan, terukur, dan berkelanjutan.',
                'body' => 'UPMI STIKes Bogor Husada mengelola dokumen mutu, audit internal, survey, dan pelaporan SPMI dalam satu sistem yang lebih tertata.',
                'button_label' => 'Jelajahi Dokumen',
                'button_url' => '/dokumen-publik',
                'sort_order' => 1,
            ],
            [
                'section' => 'about',
                'key' => 'about-main',
                'subtitle' => 'Tentang UPMI',
                'title' => 'Menjaga standar mutu dengan kerja yang konsisten.',
                'body' => 'Unit Penjaminan Mutu Internal memastikan pelaksanaan SPMI berjalan objektif, transparan, dan partisipatif untuk mendukung mutu akademik dan non-akademik.',
                'sort_order' => 1,
            ],
            [
                'section' => 'service',
                'key' => 'service-ami',
                'title' => 'Audit Mutu Internal',
                'body' => 'Pelaksanaan audit berkala untuk menilai kesesuaian standar dan praktik mutu.',
                'sort_order' => 1,
            ],
            [
                'section' => 'service',
                'key' => 'service-pelaporan',
                'title' => 'Pelaporan SPMI',
                'body' => 'Dokumentasi pelaksanaan siklus penjaminan mutu pada setiap unit kerja.',
                'sort_order' => 2,
            ],
            [
                'section' => 'service',
                'key' => 'service-dokumen',
                'title' => 'Dokumen Mutu',
                'body' => 'Pengelolaan dokumen standar, manual, formulir, dan arsip mutu.',
                'sort_order' => 3,
            ],
            [
                'section' => 'document',
                'key' => 'document-main',
                'subtitle' => 'Dokumen publik',
                'title' => 'Akses dokumen mutu yang sudah dipublikasikan.',
                'body' => 'Temukan dokumen standar, manual, dan informasi mutu yang dapat diakses publik.',
                'button_label' => 'Buka Dokumen Publik',
                'button_url' => '/dokumen-publik',
                'sort_order' => 1,
            ],
            [
                'section' => 'document',
                'key' => 'document-manual',
                'title' => 'Manual SPMI',
                'sort_order' => 2,
            ],
            [
                'section' => 'document',
                'key' => 'document-standar',
                'title' => 'Standar Mutu',
                'sort_order' => 3,
            ],
            [
                'section' => 'document',
                'key' => 'document-ami',
                'title' => 'Laporan AMI',
                'sort_order' => 4,
            ],
            [
                'section' => 'contact',
                'key' => 'contact-main',
                'subtitle' => 'Kontak',
                'title' => 'Butuh informasi lebih lanjut?',
                'body' => 'Tim Unit Penjaminan Mutu Internal STIKes Bogor Husada siap membantu kebutuhan informasi mutu akademik dan non-akademik.',
                'button_label' => 'Hubungi UPMI',
                'button_url' => 'mailto:upmi@stikesbogorhusada.ac.id',
                'sort_order' => 1,
            ],
        ];

        foreach ($contents as $content) {
            SiteContent::updateOrCreate(
                ['key' => $content['key']],
                $content + ['is_active' => true]
            );
        }
    }
}
