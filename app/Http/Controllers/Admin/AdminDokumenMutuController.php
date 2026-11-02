<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AppNotification;
use App\Models\DocumentVersion;
use App\Models\DokumenMutu;
use App\Models\KategoriDokumen;
use App\Models\SubKategoriDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDokumenMutuController extends Controller
{
    public function index()
    {
        $dokumens = DokumenMutu::with(['kategori', 'subKategori', 'revisiDari', 'approver'])->latest()->get();

        return view('admin.dokumen.index', compact('dokumens'));
    }

    public function create(Request $request)
    {
        $kategoris = KategoriDokumen::all();
        $subkategoris = SubKategoriDokumen::all();
        $revisi_dari = $request->get('revisi');

        $dokumenDirevisi = null;
        if ($revisi_dari) {
            $dokumenDirevisi = DokumenMutu::find($revisi_dari);
        }

        return view('admin.dokumen.create', compact('kategoris', 'revisi_dari', 'dokumenDirevisi', 'subkategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_dokumen' => 'required|string|max:100|unique:dokumen_mutus,kode_dokumen',
            'judul' => 'required|string|max:255',
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'sub_kategori_id' => 'required|exists:sub_kategori_dokumens,id',
            'versi' => 'required|string|max:50',
            'tanggal_terbit' => 'required|date',
            'file_path' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'status' => 'required|in:Aktif,Revisi,Tidak Berlaku',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:Publik,Internal',
        ]);

        $disk = $request->tipe === 'Publik' ? 'public' : 'local';
        $file = $request->file('file_path')->store('dokumen', $disk);

        $dokumen = DokumenMutu::create([
            'kode_dokumen' => $request->kode_dokumen,
            'judul' => $request->judul,
            'kategori_dokumen_id' => $request->kategori_dokumen_id,
            'sub_kategori_id' => $request->sub_kategori_id,
            'versi' => $request->versi,
            'tanggal_terbit' => $request->tanggal_terbit,
            'file_path' => $file,
            'status' => $request->status ?? 'Aktif',
            'approval_status' => 'pending',
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'uploaded_by' => auth()->id(),
            'revisi_dari' => $request->revisi_dari,
        ]);

        $this->recordVersion($dokumen);

        ActivityLog::record('create', 'dokumen', $dokumen, [], $dokumen->only([
            'kode_dokumen',
            'judul',
            'kategori_dokumen_id',
            'sub_kategori_id',
            'versi',
            'tanggal_terbit',
            'status',
            'approval_status',
            'tipe',
            'uploaded_by',
            'revisi_dari',
        ]));
        AppNotification::notifyAdmins('Dokumen menunggu approval', $dokumen->kode_dokumen.' - '.$dokumen->judul, route('admin.dokumen.show', $dokumen));

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
            'kode_dokumen' => 'required|string|max:100|unique:dokumen_mutus,kode_dokumen,'.$dokumen->id,
            'judul' => 'required|string|max:255',
            'kategori_dokumen_id' => 'required|exists:kategori_dokumen,id',
            'sub_kategori_id' => 'required|exists:sub_kategori_dokumens,id',
            'versi' => 'required|string|max:50',
            'tanggal_terbit' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'status' => 'required|in:Aktif,Revisi,Tidak Berlaku',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:Publik,Internal',
        ]);

        $before = $dokumen->only([
            'kode_dokumen',
            'judul',
            'kategori_dokumen_id',
            'sub_kategori_id',
            'versi',
            'tanggal_terbit',
            'status',
            'approval_status',
            'tipe',
            'file_path',
        ]);

        if ($request->hasFile('file_path')) {
            $this->deleteFromStorage($dokumen->file_path);

            $disk = $request->tipe === 'Publik' ? 'public' : 'local';
            $file = $request->file('file_path')->store('dokumen', $disk);
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
            'approval_status' => 'pending',
            'approval_note' => null,
            'approved_by' => null,
            'approved_at' => null,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
        ]);

        $this->recordVersion($dokumen->fresh());

        ActivityLog::record('update', 'dokumen', $dokumen, $before, $dokumen->fresh()->only(array_keys($before)));
        AppNotification::notifyAdmins('Dokumen diperbarui dan perlu approval ulang', $dokumen->kode_dokumen.' - '.$dokumen->judul, route('admin.dokumen.show', $dokumen));

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function show(DokumenMutu $dokumen)
    {

        $dokumen->load(['versions.creator', 'approver']);
        $revisiAnak = $dokumen->revisiAnak;

        return view('admin.dokumen.show', [
            'dokumen' => $dokumen,
            'revisiAnak' => $dokumen->revisiAnak,
        ]);
    }

    public function destroy(DokumenMutu $dokumen)
    {
        // dd($dokumenMutu);
        // Cek dulu apakah file_path ada dan tidak null
        ActivityLog::record('delete', 'dokumen', $dokumen, $dokumen->only([
            'kode_dokumen',
            'judul',
            'versi',
            'status',
            'tipe',
            'file_path',
        ]));

        $this->deleteFromStorage($dokumen->file_path);

        $dokumen->forceDelete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(DokumenMutu $dokumen)
    {
        ActivityLog::record('download', 'dokumen', $dokumen, [], [
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

    private function recordVersion(DokumenMutu $dokumen): void
    {
        DocumentVersion::create([
            'dokumen_mutu_id' => $dokumen->id,
            'version_label' => $dokumen->versi ?: 'v1',
            'file_path' => $dokumen->file_path,
            'created_by' => auth()->id(),
            'snapshot' => $dokumen->only([
                'kode_dokumen',
                'judul',
                'kategori_dokumen_id',
                'sub_kategori_id',
                'versi',
                'tanggal_terbit',
                'status',
                'approval_status',
                'tipe',
                'file_path',
            ]),
        ]);
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! auth()->user()->hasAnyRole(['admin-upmi', 'super-admin'])) {
                abort(403, 'Akses ditolak.');
            }

            return $next($request);
        })->only(['create', 'store', 'destroy']);
    }
}
