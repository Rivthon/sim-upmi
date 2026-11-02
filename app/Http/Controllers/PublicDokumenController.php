<?php

namespace App\Http\Controllers;

use App\Models\DokumenMutu;
use App\Models\KategoriDokumen;
use App\Models\SubKategoriDokumen;
use Illuminate\Support\Facades\Storage;

class PublicDokumenController extends Controller
{
    // Menampilkan daftar kategori publik & subkategorinya
    public function index()
    {
        $kategoris = KategoriDokumen::with('subKategoris')
            ->where('tipe', 'Publik')
            ->get();

        return view('public.dokumen.index', compact('kategoris'));
    }

    // Menampilkan dokumen berdasarkan subkategori
    public function showBySubKategori(SubKategoriDokumen $subkategori)
    {
        $dokumens = DokumenMutu::where('sub_kategori_id', $subkategori->id)
            ->where('tipe', 'Publik')
            ->where('status', 'Aktif')
            ->where('approval_status', 'approved')
            ->latest()
            ->get();

        return view('public.dokumen.by-subkategori', compact('dokumens', 'subkategori'));
    }

    public function show($slug)
    {
        $subkategori = SubKategoriDokumen::where('slug', $slug)->firstOrFail();
        $dokumens = DokumenMutu::where('sub_kategori_id', $subkategori->id)
            ->where('tipe', 'Publik')
            ->where('status', 'Aktif')
            ->where('approval_status', 'approved')
            ->latest()
            ->get();

        return view('public.dokumen.show', compact('subkategori', 'dokumens'));
    }

    public function download(DokumenMutu $dokumen)
    {
        abort_unless($dokumen->tipe === 'Publik' && $dokumen->status === 'Aktif' && $dokumen->approval_status === 'approved', 404);
        abort_if(empty($dokumen->file_path) || ! Storage::disk('public')->exists($dokumen->file_path), 404);

        return Storage::disk('public')->download($dokumen->file_path, basename($dokumen->file_path));
    }
}
