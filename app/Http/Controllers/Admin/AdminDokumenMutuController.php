<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenMutu;
use App\Models\KategoriDokumen;
use App\Models\SubKategoriDokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminDokumenMutuController extends Controller
{
public function index()
{
    $dokumens = DokumenMutu::with(['kategori', 'subKategori', 'revisiDari'])->latest()->get();

    return view('admin.dokumen.index', compact('dokumens'));
}


public function create(Request $request)
{
    $kategoris = KategoriDokumen::all();
    $subkategoris = SubKategoriDokumen::all();
    $revisi_dari = $request->get('revisi');

    $dokumenDirevisi = null;
    if ($revisi_dari) {
        $dokumenDirevisi = \App\Models\DokumenMutu::find($revisi_dari);
    }

    return view('admin.dokumen.create', compact('kategoris', 'revisi_dari', 'dokumenDirevisi','subkategoris'));
}

public function store(Request $request)
{
    $request->validate([
        'kode_dokumen' => 'required|string|max:100|unique:dokumen_mutus,kode_dokumen',
        'judul' => 'required|string|max:255',
        'kategori_dokumen_id' => 'required|exists:kategori_dokumens,id',
        'sub_kategori_id' => 'required|exists:sub_kategori_dokumens,id',
        'versi' => 'required|string|max:50',
        'tanggal_terbit' => 'required|date',
        'file_path' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'status' => 'required|in:Aktif,Revisi,Tidak Berlaku',
        'deskripsi' => 'nullable|string',
        'tipe' => 'required|in:Publik,Internal',
    ]);

    $file = $request->file('file_path')->store('dokumen', 'public');

    DokumenMutu::create([
        'kode_dokumen' => $request->kode_dokumen,
        'judul' => $request->judul,
        'kategori_dokumen_id' => $request->kategori_dokumen_id,
        'sub_kategori_id' => $request->sub_kategori_id,
        'versi' => $request->versi,
        'tanggal_terbit' => $request->tanggal_terbit,
        'file_path' => $file,
        'status' => $request->status ?? 'Aktif',
        'deskripsi' => $request->deskripsi,
        'tipe' => $request->tipe,
        'uploaded_by' => auth()->id(),
    ]);

    return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diunggah.');
}

public function edit($id)
{
    $dokumen = DokumenMutu::findOrFail($id);
    $kategoris = KategoriDokumen::all();
    $subkategoris = SubKategoriDokumen::where('kategori_dokumen_id', $dokumen->kategori_dokumen_id)->get();

    return view('admin.dokumen.edit', compact('dokumen', 'kategoris', 'subkategoris'));
}



public function update(Request $request, DokumenMutu $dokumen)
{
    $request->validate([
        'kode_dokumen' => 'required|string|max:100|unique:dokumen_mutus,kode_dokumen,' . $dokumen->id,
        'judul' => 'required|string|max:255',
        'kategori_dokumen_id' => 'required|exists:kategori_dokumens,id',
        'sub_kategori_id' => 'required|exists:sub_kategori_dokumens,id',
        'versi' => 'required|string|max:50',
        'tanggal_terbit' => 'required|date',
        'file_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        'status' => 'required|in:Aktif,Revisi,Tidak Berlaku',
        'deskripsi' => 'nullable|string',
        'tipe' => 'required|in:Publik,Internal',
    ]);

    if ($request->hasFile('file_path')) {
        $file = $request->file('file_path')->store('dokumen', 'public');
        $dokumen->file_path = $file;
    }

    $dokumen->update([
        'kode_dokumen' => $request->kode_dokumen,
        'judul' => $request->judul,
        'kategori_dokumen_id' => $request->kategori_dokumen_id,
        'sub_kategori_id' => $request->sub_kategori_id,
        'versi' => $request->versi,
        'tanggal_terbit' => $request->tanggal_terbit,
        'status' => $request->status,
        'deskripsi' => $request->deskripsi,
        'tipe' => $request->tipe,
    ]);

    return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
}




public function show(DokumenMutu $dokumen)
{
        
    $revisiAnak = $dokumen->revisiAnak;
        return view('admin.dokumen.show', [
        'dokumen' => $dokumen,
        'revisiAnak' => $dokumen->revisiAnak
    ]);
}



    public function destroy(DokumenMutu $dokumenMutu)
    {
        if (Storage::disk('public')->exists($dokumenMutu->file_path)) {
            Storage::disk('public')->delete($dokumenMutu->file_path);
        }
        $dokumenMutu->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function __construct()
{
    $this->middleware(function ($request, $next) {
        if (!auth()->user()->hasAnyRole(['admin-upmi', 'super-admin'])) {
            abort(403, 'Akses ditolak.');
        }
        return $next($request);
    })->only(['create', 'store', 'destroy']);
}

}
