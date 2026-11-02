<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AppNotification;
use App\Models\JadwalAmi;
use Illuminate\Http\Request;

class AmiFollowUpController extends Controller
{
    public function index()
    {
        $items = JadwalAmi::with('auditors')
            ->whereNotNull('hasil_temuan')
            ->orWhereNotNull('tindak_lanjut')
            ->latest()
            ->get();

        return view('admin.ami-follow-up.index', compact('items'));
    }

    public function edit(JadwalAmi $ami)
    {
        return view('admin.ami-follow-up.edit', compact('ami'));
    }

    public function update(Request $request, JadwalAmi $ami)
    {
        $data = $request->validate([
            'hasil_temuan' => ['nullable', 'string'],
            'tindak_lanjut' => ['nullable', 'string'],
            'status_tindak_lanjut' => ['required', 'in:belum,proses,selesai'],
            'target_selesai_tindak_lanjut' => ['nullable', 'date'],
        ]);

        $trackedFields = array_merge(array_keys($data), ['selesai_tindak_lanjut_pada']);
        $before = $ami->only($trackedFields);
        $data['selesai_tindak_lanjut_pada'] = $data['status_tindak_lanjut'] === 'selesai' ? now() : null;

        $ami->update($data);

        ActivityLog::record('update', 'tindak-lanjut-ami', $ami, $before, $ami->fresh()->only($trackedFields));
        AppNotification::notifyAdmins('Tindak lanjut AMI diperbarui', $ami->judul, route('admin.ami-follow-up.edit', $ami));

        return redirect()->route('admin.ami-follow-up.index')->with('success', 'Tindak lanjut AMI berhasil diperbarui.');
    }
}
