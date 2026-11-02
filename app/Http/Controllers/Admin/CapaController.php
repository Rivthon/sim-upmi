<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Capa;
use App\Models\JadwalAmi;
use App\Models\ManagementReview;
use Illuminate\Http\Request;

class CapaController extends Controller
{
    public function index()
    {
        $capas = Capa::with(['managementReview', 'ami'])->latest()->get();

        return view('admin.capas.index', compact('capas'));
    }

    public function create()
    {
        return view('admin.capas.create', $this->formData(new Capa(['status' => 'open'])));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['closed_at'] = $data['status'] === 'closed' ? now() : null;
        $capa = Capa::create($data);
        ActivityLog::record('create', 'capa', $capa, [], $capa->toArray());

        return redirect()->route('admin.capas.index')->with('success', 'CAPA berhasil ditambahkan.');
    }

    public function edit(Capa $capa)
    {
        return view('admin.capas.edit', $this->formData($capa));
    }

    public function update(Request $request, Capa $capa)
    {
        $before = $capa->toArray();
        $data = $this->validatedData($request);
        $data['closed_at'] = $data['status'] === 'closed' ? ($capa->closed_at ?? now()) : null;
        $capa->update($data);
        ActivityLog::record('update', 'capa', $capa, $before, $capa->fresh()->toArray());

        return redirect()->route('admin.capas.index')->with('success', 'CAPA berhasil diperbarui.');
    }

    public function destroy(Capa $capa)
    {
        ActivityLog::record('delete', 'capa', $capa, $capa->toArray());
        $capa->delete();

        return back()->with('success', 'CAPA berhasil dihapus.');
    }

    private function formData(Capa $capa): array
    {
        return [
            'capa' => $capa,
            'reviews' => ManagementReview::latest('meeting_date')->get(),
            'amis' => JadwalAmi::latest()->get(),
        ];
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'management_review_id' => ['nullable', 'exists:management_reviews,id'],
            'jadwal_ami_id' => ['nullable', 'exists:jadwal_amis,id'],
            'title' => ['required', 'string', 'max:255'],
            'root_cause' => ['nullable', 'string'],
            'corrective_action' => ['nullable', 'string'],
            'preventive_action' => ['nullable', 'string'],
            'effectiveness_check' => ['nullable', 'string'],
            'pic' => ['nullable', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
            'status' => ['required', 'in:open,proses,closed'],
        ]);
    }
}
