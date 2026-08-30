<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\KategoriDokumen;
use Illuminate\Http\Request;

class AdminKategoriDokumenController extends Controller
{
    public function index()
    {
        $kategoris = KategoriDokumen::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:Publik,Internal',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriDokumen::create($request->all());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

public function edit($id)
{
    $kategori = KategoriDokumen::findOrFail($id);
    return view('admin.kategori.edit', compact('kategori'));
}


public function update(Request $request, $id)
{
    $data = $request->validate([
        'nama' => 'required|string|max:255',
        'tipe' => 'required|in:Publik,Internal',
        'deskripsi' => 'nullable|string',
    ]);

    $kategori = KategoriDokumen::findOrFail($id);
    $kategori->update($data);

    return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
}


    public function destroy(KategoriDokumen $kategori)
    {
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
