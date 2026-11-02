<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{
    public function index()
    {
        $accreditations = Accreditation::latest()->get();

        return view('admin.accreditations.index', compact('accreditations'));
    }

    public function create()
    {
        return view('admin.accreditations.create', ['accreditation' => new Accreditation([
            'document_progress' => 0,
            'status' => 'persiapan',
        ])]);
    }

    public function store(Request $request)
    {
        $accreditation = Accreditation::create($this->validatedData($request));
        ActivityLog::record('create', 'akreditasi', $accreditation, [], $accreditation->toArray());

        return redirect()->route('admin.accreditations.index')->with('success', 'Data akreditasi berhasil ditambahkan.');
    }

    public function edit(Accreditation $accreditation)
    {
        return view('admin.accreditations.edit', compact('accreditation'));
    }

    public function update(Request $request, Accreditation $accreditation)
    {
        $before = $accreditation->toArray();
        $accreditation->update($this->validatedData($request));
        ActivityLog::record('update', 'akreditasi', $accreditation, $before, $accreditation->fresh()->toArray());

        return redirect()->route('admin.accreditations.index')->with('success', 'Data akreditasi berhasil diperbarui.');
    }

    public function destroy(Accreditation $accreditation)
    {
        ActivityLog::record('delete', 'akreditasi', $accreditation, $accreditation->toArray());
        $accreditation->delete();

        return back()->with('success', 'Data akreditasi berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'program_name' => ['required', 'string', 'max:255'],
            'agency' => ['nullable', 'string', 'max:255'],
            'instrument' => ['nullable', 'string', 'max:255'],
            'current_rank' => ['nullable', 'string', 'max:60'],
            'target_rank' => ['nullable', 'string', 'max:60'],
            'submission_date' => ['nullable', 'date'],
            'assessment_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
            'document_progress' => ['required', 'integer', 'min:0', 'max:100'],
            'pic' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:persiapan,submit,asesmen,menunggu hasil,selesai'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
