<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PelaporanSpmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPelaporanSpmiController extends Controller
{
    public function index()
    {
        $pelaporans = PelaporanSpmi::with('creator')->latest()->get();

        return view('admin.pelaporan.index', compact('pelaporans'));
    }

    public function create()
    {
        return view('admin.pelaporan.create');
    }

    public function store(Request $request)
    {
        //    dd($request->file('bukti_pendukung')); // Debug dulu

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'unit' => 'required|string',
            'sub_unit' => 'nullable|string|max:100',
            'periode' => 'required|string|max:100',
            'tahapan' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'status' => 'required|in:Draft,Final',
            'bukti_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti_pendukung')) {
            $path = $request->file('bukti_pendukung')->store('bukti_pendukung', 'local');
            $data['bukti_pendukung'] = $path;
        }

        $pelaporan = PelaporanSpmi::create(array_merge($data, [
            'created_by' => auth()->id(),
        ]));

        ActivityLog::record('create', 'pelaporan', $pelaporan, [], $pelaporan->only([
            'judul',
            'unit',
            'sub_unit',
            'periode',
            'tahapan',
            'tanggal',
            'status',
            'created_by',
        ]));

        return redirect()->route('admin.pelaporan.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $pelaporan = PelaporanSpmi::findOrFail($id);

        return view('admin.pelaporan.edit', compact('pelaporan'));
    }

    public function update(Request $request, PelaporanSpmi $pelaporan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'unit' => 'required|string',
            'sub_unit' => 'nullable|string|max:100',
            'tanggal' => 'required|date',
            'tahapan' => 'required|in:Penetapan,Pelaksanaan,Evaluasi,Pengendalian,Peningkatan',
            'deskripsi' => 'nullable|string',
            'bukti_pendukung' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png|max:2048',
            'status' => 'required|in:Draft,Final',
        ]);

        $data = $request->only(['judul', 'unit', 'sub_unit', 'tanggal', 'tahapan', 'deskripsi', 'status']);
        $before = $pelaporan->only([
            'judul',
            'unit',
            'sub_unit',
            'periode',
            'tahapan',
            'tanggal',
            'status',
            'bukti_pendukung',
        ]);

        if ($request->hasFile('bukti_pendukung')) {
            $this->deleteFromStorage($pelaporan->bukti_pendukung);

            $file = $request->file('bukti_pendukung')->store('bukti_pendukung', 'local');
            $data['bukti_pendukung'] = $file;
        }

        $pelaporan->update($data);

        ActivityLog::record('update', 'pelaporan', $pelaporan, $before, $pelaporan->fresh()->only(array_keys($before)));

        return redirect()->route('admin.pelaporan.index')->with('success', 'Pelaporan berhasil diperbarui.');
    }

    public function show(PelaporanSpmi $pelaporan)
    {
        $pelaporan->load('creator');

        return view('admin.pelaporan.show', compact('pelaporan'));
    }

    public function destroy($pelaporan)
    {
        $pelaporan = PelaporanSpmi::findOrFail($pelaporan);

        ActivityLog::record('delete', 'pelaporan', $pelaporan, $pelaporan->only([
            'judul',
            'unit',
            'sub_unit',
            'periode',
            'tahapan',
            'tanggal',
            'status',
            'bukti_pendukung',
        ]));

        // Hapus file jika ada
        $this->deleteFromStorage($pelaporan->bukti_pendukung);

        // Hapus data dari database
        $pelaporan->delete();

        return redirect()->route('admin.pelaporan.index')->with('success', 'Data pelaporan berhasil dihapus.');
    }

    public function download(PelaporanSpmi $pelaporan)
    {
        ActivityLog::record('download', 'pelaporan', $pelaporan, [], [
            'judul' => $pelaporan->judul,
            'bukti_pendukung' => $pelaporan->bukti_pendukung,
        ]);

        return $this->downloadFromStorage($pelaporan->bukti_pendukung);
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
