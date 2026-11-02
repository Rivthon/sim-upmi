<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriDokumen;
use App\Models\SiteContent;

class WelcomeController extends Controller
{
    public function index()
    {
        $kategorisPublik = KategoriDokumen::with('subKategoris')
            ->where('tipe', 'Publik')
            ->get();
        $beritas = Berita::latest()->take(6)->get();
        $contents = SiteContent::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $contentsByKey = $contents->keyBy('key');

        $hero = $this->content($contentsByKey, 'hero-main', [
            'subtitle' => 'Sistem Penjaminan Mutu Internal',
            'title' => 'Budaya mutu yang transparan, terukur, dan berkelanjutan.',
            'body' => 'UPMI STIKes Bogor Husada mengelola dokumen mutu, audit internal, survey, dan pelaporan SPMI dalam satu sistem yang lebih tertata.',
            'button_label' => 'Jelajahi Dokumen',
            'button_url' => route('dokumen.publik.index'),
        ]);

        $about = $this->content($contentsByKey, 'about-main', [
            'subtitle' => 'Tentang UPMI',
            'title' => 'Menjaga standar mutu dengan kerja yang konsisten.',
            'body' => 'Unit Penjaminan Mutu Internal memiliki peran penting dalam memastikan pelaksanaan SPMI berjalan objektif, transparan, dan partisipatif. Sistem ini membantu civitas akademika mengakses dokumen, mengikuti survey, dan memantau proses mutu secara lebih mudah.',
        ]);

        $documentIntro = $this->content($contentsByKey, 'document-main', [
            'subtitle' => 'Dokumen publik',
            'title' => 'Akses dokumen mutu yang sudah dipublikasikan.',
            'body' => 'Temukan dokumen standar, manual, dan informasi mutu yang dapat diakses publik.',
            'button_label' => 'Buka Dokumen Publik',
            'button_url' => route('dokumen.publik.index'),
        ]);

        $contact = $this->content($contentsByKey, 'contact-main', [
            'subtitle' => 'Kontak',
            'title' => 'Butuh informasi lebih lanjut?',
            'body' => 'Tim Unit Penjaminan Mutu Internal STIKes Bogor Husada siap membantu kebutuhan informasi mutu akademik dan non-akademik.',
            'button_label' => 'Hubungi UPMI',
            'button_url' => 'mailto:upmi@stikesbogorhusada.ac.id',
        ]);

        $services = $this->contentList($contents, 'service', [
            ['title' => 'Audit Mutu Internal', 'body' => 'Pelaksanaan audit berkala untuk menilai kesesuaian standar dan praktik mutu.'],
            ['title' => 'Pelaporan SPMI', 'body' => 'Dokumentasi pelaksanaan siklus penjaminan mutu pada setiap unit kerja.'],
            ['title' => 'Dokumen Mutu', 'body' => 'Pengelolaan dokumen standar, manual, formulir, dan arsip mutu.'],
        ]);

        $documents = $this->contentList($contents, 'document', [
            ['title' => 'Manual SPMI'],
            ['title' => 'Standar Mutu'],
            ['title' => 'Laporan AMI'],
        ], ['document-main']);

        return view('welcome', compact('kategorisPublik', 'beritas', 'hero', 'about', 'documentIntro', 'contact', 'services', 'documents'));
    }

    private function content($contentsByKey, string $key, array $defaults): array
    {
        $content = $contentsByKey->get($key);

        if (! $content) {
            return $defaults;
        }

        $values = collect($content->only([
            'title',
            'subtitle',
            'body',
            'button_label',
            'button_url',
            'image_path',
        ]))->filter(fn ($value) => ! blank($value))->all();

        return array_merge($defaults, $values);
    }

    private function contentList($contents, string $section, array $fallbacks, array $exceptKeys = [])
    {
        $items = $contents
            ->where('section', $section)
            ->reject(fn (SiteContent $content) => in_array($content->key, $exceptKeys, true))
            ->map(fn (SiteContent $content) => collect($content->only([
                'title',
                'subtitle',
                'body',
                'button_label',
                'button_url',
                'image_path',
            ]))->filter(fn ($value) => ! blank($value))->all())
            ->values();

        return $items->isNotEmpty() ? $items : collect($fallbacks);
    }
}
