<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalAmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AdminJadwalAmiController extends Controller
{
    public function index()
    {
        $jadwals = JadwalAmi::latest()->get();
        return view('admin.ami.index', compact('jadwals'));
    }

public function create()
{
    $auditors = User::role('Auditor')->get(); // Ambil semua user dengan role Auditor
    return view('admin.ami.create', compact('auditors'));
}


public function store(Request $request)
{
    $data = $request->validate([
        'judul' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'unit' => 'required|string|max:100',
        'sub_unit' => 'nullable|string|max:100', // ← pastikan ada
        'tahun' => 'required|digits:4',
        'status' => 'required|in:Draft,Selesai',
        'deskripsi' => 'nullable|string',
        'dibuat_oleh' => 'nullable|string',
         'auditors' => 'required|array', // multiple auditors
        'auditors.*' => 'exists:users,id',
    ]);

    $data['dibuat_oleh'] = Auth::id();

    $jadwal = JadwalAmi::create($data); // $data sudah termasuk sub_unit
    $jadwal->auditors()->attach($request->auditors); // simpan relasi ke pivot

    return redirect()->route('admin.ami.index')->with('success', 'Jadwal AMI berhasil ditambahkan.');
}



    public function show(JadwalAmi $jadwalAmi)
    {
        return view('admin.ami.show', compact('jadwalAmi'));
    }

public function edit(JadwalAmi $jadwalAmi)
{
    $auditors = User::role('Auditor')->get();
    return view('admin.ami.edit', compact('jadwalAmi', 'auditors'));
}


    public function update(Request $request, JadwalAmi $jadwalAmi)
    {
        $data = $request->validate([
       'judul' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'unit' => 'required|string|max:100',
        'sub_unit' => 'nullable|string|max:100', // ← pastikan ada
        'tahun' => 'required|digits:4',
        'status' => 'required|in:Draft,Selesai',
        'deskripsi' => 'nullable|string',
        'dibuat_oleh' => 'nullable|string',
        'auditors' => 'required|array',
        'auditors.*' => 'exists:users,id',
    ]);

    $jadwalAmi->update($data);
    $jadwalAmi->auditors()->sync($request->auditors); // update pivot

    if ($request->filled('auditors')) {
        $jadwalAmi->auditors()->sync($request->auditors);
    }

    return redirect()->route('admin.ami.index')->with('success', 'Jadwal AMI berhasil diperbarui.');
}

    public function destroy(JadwalAmi $jadwalAmi)
    {
        $jadwalAmi->delete();
        return redirect()->back()->with('success', 'Jadwal AMI berhasil dihapus.');
    }
    public function selesaikan($id)
{
    $jadwal = JadwalAmi::findOrFail($id);
    $jadwal->update(['status' => 'Selesai']); // Atau 'Selesai' jika enum kamu pakai itu
    return redirect()->route('admin.ami.index')->with('success', 'Status berhasil diubah menjadi Selesai.');
}
public function updateTemuan(Request $request, JadwalAmi $ami)
{
    $request->validate([
        'hasil_temuan' => 'nullable|string',
        'tindak_lanjut' => 'nullable|string',
    ]);

    $ami->update([
        'hasil_temuan' => $request->hasil_temuan,
        'tindak_lanjut' => $request->tindak_lanjut,
    ]);

    return redirect()->route('admin.ami.show', $ami->id)
                     ->with('success', 'Hasil temuan dan tindak lanjut berhasil diperbarui.');
}

}
