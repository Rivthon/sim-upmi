<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DokumenMutu;
use App\Models\KategoriDokumen;
use App\Models\SubKategoriDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    // Tampilkan daftar dokumen yang diunggah oleh user
    public function index()
    {
        $dokumenUser = DokumenMutu::where('uploaded_by', auth()->id())->latest()->get();

        return view('user.dokumen.index', compact('dokumenUser'));
    }

    // Form upload
    public function create()
    {
        $kategoris = KategoriDokumen::with('subKategoris')
            ->where('tipe', 'Internal')
            ->get();

        return view('user.dokumen.create', compact('kategoris'));
    }

    // Simpan dokumen
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kode_dokumen' => 'required|string|max:100|unique:dokumen_mutus,kode_dokumen',
            'tanggal_terbit' => 'required|date',
            'versi' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'sub_kategori_id' => 'required|exists:sub_kategori_dokumens,id',
            'file_path' => 'required|file|mimes:pdf,doc,docx|max:5120', // max 5MB
        ]);

        $path = $request->file('file_path')->store('dokumen', 'local');

        $sub = SubKategoriDokumen::findOrFail($request->sub_kategori_id);
        $dokumen = DokumenMutu::create([
            'judul' => $request->judul,
            'kode_dokumen' => $request->kode_dokumen,
            'tanggal_terbit' => $request->tanggal_terbit,
            'versi' => $request->versi,
            'deskripsi' => $request->deskripsi,
            'kategori_dokumen_id' => $sub->kategori_dokumen_id, // ← otomatis dari subkategori
            'sub_kategori_id' => $sub->id,
            'file_path' => $path,
            'tipe' => 'Internal', // tetap dipaksa internal
            'status' => 'Aktif',
            'uploaded_by' => Auth::id(),
        ]);

        ActivityLog::record('create', 'dokumen-user', $dokumen, [], $dokumen->only([
            'kode_dokumen',
            'judul',
            'kategori_dokumen_id',
            'sub_kategori_id',
            'versi',
            'tanggal_terbit',
            'status',
            'tipe',
            'uploaded_by',
        ]));

        return redirect()->route('user.dokumen.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    public function edit($id)
    {
        $kategoris = KategoriDokumen::with('subKategoris')
            ->where('tipe', 'Internal')
            ->get();

        $dokumen = DokumenMutu::findOrFail($id);
        $subKategoris = SubKategoriDokumen::whereHas('kategori', function ($q) {
            $q->where('tipe', 'Internal');
        })->get();

        return view('user.dokumen.edit', compact('dokumen', 'subKategoris', 'kategoris'));
    }

    // Simpan perubahan
    public function update(Request $request, $id)
    {
        $dokumen = DokumenMutu::findOrFail($id);
        if ($dokumen->uploaded_by !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'kode_dokumen' => 'nullable|string|max:100',
            'tanggal_terbit' => 'required|date',
            'versi' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string',
            'sub_kategori_id' => 'required|exists:sub_kategori_dokumens,id',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $sub = SubKategoriDokumen::findOrFail($request->sub_kategori_id);
        $before = $dokumen->only([
            'kode_dokumen',
            'judul',
            'kategori_dokumen_id',
            'sub_kategori_id',
            'versi',
            'tanggal_terbit',
            'deskripsi',
            'file_path',
        ]);

        // Ganti file jika ada
        if ($request->hasFile('file_path')) {
            $this->deleteFromStorage($dokumen->file_path);
            $filePath = $request->file('file_path')->store('dokumen', 'local');
            $dokumen->file_path = $filePath;
        }

        $dokumen->update([
            'judul' => $request->judul,
            'kode_dokumen' => $request->kode_dokumen ?: '',
            'tanggal_terbit' => $request->tanggal_terbit,
            'versi' => $request->versi,
            'deskripsi' => $request->deskripsi,
            'kategori_dokumen_id' => $sub->kategori_dokumen_id,
            'sub_kategori_id' => $sub->id,
            'file_path' => $dokumen->file_path,
        ]);

        ActivityLog::record('update', 'dokumen-user', $dokumen, $before, $dokumen->fresh()->only(array_keys($before)));

        return redirect()->route('user.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    // Hapus dokumen
    public function destroy($id)
    {
        $dokumen = DokumenMutu::findOrFail($id);
        if ($dokumen->uploaded_by !== auth()->id()) {
            abort(403);
        }

        ActivityLog::record('delete', 'dokumen-user', $dokumen, $dokumen->only([
            'kode_dokumen',
            'judul',
            'versi',
            'file_path',
            'uploaded_by',
        ]));

        $this->deleteFromStorage($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download($id)
    {
        $dokumen = DokumenMutu::findOrFail($id);

        if ($dokumen->uploaded_by !== auth()->id()) {
            abort(403);
        }

        ActivityLog::record('download', 'dokumen-user', $dokumen, [], [
            'kode_dokumen' => $dokumen->kode_dokumen,
            'judul' => $dokumen->judul,
            'file_path' => $dokumen->file_path,
        ]);

        return $this->downloadFromStorage($dokumen->file_path);
    }

    private function downloadFromStorage(?string $path)
    {
        abort_if(empty($path), 404);

        foreach (['local', 'public'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->download($path, basename($path));
            }
        }

        abort(404);
    }

    private function deleteFromStorage(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        foreach (['local', 'public'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }
    }
}
