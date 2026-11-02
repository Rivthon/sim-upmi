<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriDokumen;
use App\Models\SubKategoriDokumen;
use Illuminate\Http\Request;

class SubKategoriDokumenController extends Controller
{
    public function index()
    {
        $subkategoris = SubKategoriDokumen::with('kategori')->withCount('dokumenMutus')->latest()->get();

        return view('admin.kategori.subkategori.index', compact('subkategoris'));
    }

    public function create()
    {
        $kategoris = KategoriDokumen::all();

        return view('admin.kategori.subkategori.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        SubKategoriDokumen::create($data);

        return redirect()->route('admin.subkategori.index')->with('success', 'Sub Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $subkategori = SubKategoriDokumen::findOrFail($id);
        $kategoris = KategoriDokumen::all(); // Untuk dropdown kategori

        return view('admin.kategori.subkategori.edit', compact('subkategori', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $subkategori = SubKategoriDokumen::findOrFail($id);
        $subkategori->update($data);

        return redirect()->route('admin.subkategori.index')->with('success', 'Sub Kategori berhasil diperbarui.');
    }

    public function destroy(SubKategoriDokumen $subkategori)
    {
        $subkategori->delete();

        return redirect()->back()->with('success', 'Sub Kategori berhasil dihapus');
    }
}
