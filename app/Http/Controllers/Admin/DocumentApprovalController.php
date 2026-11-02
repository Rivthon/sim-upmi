<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AppNotification;
use App\Models\DokumenMutu;
use Illuminate\Http\Request;

class DocumentApprovalController extends Controller
{
    public function approve(Request $request, DokumenMutu $dokumen)
    {
        $data = $request->validate([
            'approval_note' => ['nullable', 'string'],
        ]);

        $before = $dokumen->only(['approval_status', 'approval_note', 'approved_by', 'approved_at']);

        $dokumen->update([
            'approval_status' => 'approved',
            'approval_note' => $data['approval_note'] ?? null,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        ActivityLog::record('approve', 'dokumen', $dokumen, $before, $dokumen->fresh()->only(array_keys($before)));
        AppNotification::notifyAdmins('Dokumen disetujui', $dokumen->kode_dokumen.' - '.$dokumen->judul, route('admin.dokumen.show', $dokumen));

        return back()->with('success', 'Dokumen berhasil disetujui.');
    }

    public function reject(Request $request, DokumenMutu $dokumen)
    {
        $data = $request->validate([
            'approval_note' => ['required', 'string'],
        ]);

        $before = $dokumen->only(['approval_status', 'approval_note', 'approved_by', 'approved_at']);

        $dokumen->update([
            'approval_status' => 'rejected',
            'approval_note' => $data['approval_note'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        ActivityLog::record('reject', 'dokumen', $dokumen, $before, $dokumen->fresh()->only(array_keys($before)));
        AppNotification::notifyAdmins('Dokumen ditolak', $dokumen->kode_dokumen.' - '.$dokumen->judul, route('admin.dokumen.show', $dokumen));

        return back()->with('success', 'Dokumen berhasil ditolak.');
    }
}
