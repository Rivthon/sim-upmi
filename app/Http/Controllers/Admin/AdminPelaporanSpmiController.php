<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PelaporanSpmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
            $path = $request->file('bukti_pendukung')->store('bukti_pendukung', 'public');
            $data['bukti_pendukung'] = $path;
        }

        PelaporanSpmi::create(array_merge($data, [
            // 'unit' => auth()->user()->unit,
            'created_by' => auth()->id(),
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
            'bukti_pendukung' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png',
            'status' => 'required|in:Draft,Final',
        ]);

        $data = $request->only(['judul', 'unit','sub_unit', 'tanggal', 'tahapan', 'deskripsi', 'status']);

        if ($request->hasFile('bukti_pendukung')) {
            $file = $request->file('bukti_pendukung')->store('bukti', 'public');
            $data['bukti_pendukung'] = $file;
        }

        $pelaporan->update($data);

        return redirect()->route('admin.pelaporan.index')->with('success', 'Pelaporan berhasil diperbarui.');
    }

    public function show(PelaporanSpmi $pelaporan)
    {
        $pelaporan->load('creator');
        return view('admin.pelaporan.show', compact('pelaporan'));
    }
}
