<?php

namespace App\Http\Controllers;

use App\Models\KategoriDokumen;
use App\Models\SubKategoriDokumen;
use App\Models\DokumenMutu;

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
        ->latest()
        ->get();


    return view('public.dokumen.show', compact('subkategori', 'dokumens'));
}


}
