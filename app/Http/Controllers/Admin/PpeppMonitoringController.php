<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PpeppMonitoring;
use App\Models\QualityIndicator;
use App\Models\QualityStandard;
use App\Models\User;
use Illuminate\Http\Request;

class PpeppMonitoringController extends Controller
{
    public function index()
    {
        $items = PpeppMonitoring::with(['standard', 'indicator', 'owner'])->latest()->get();

        return view('admin.ppepp-monitorings.index', compact('items'));
    }

    public function create()
    {
        return view('admin.ppepp-monitorings.create', $this->formData(new PpeppMonitoring(['cycle' => 'Penetapan', 'status' => 'draft'])));
    }

    public function store(Request $request)
    {
        $item = PpeppMonitoring::create($this->validatedData($request));
        ActivityLog::record('create', 'monitoring-ppepp', $item, [], $item->toArray());

        return redirect()->route('admin.ppepp-monitorings.index')->with('success', 'Monitoring PPEPP berhasil ditambahkan.');
    }

    public function edit(PpeppMonitoring $ppeppMonitoring)
    {
        return view('admin.ppepp-monitorings.edit', $this->formData($ppeppMonitoring));
    }

    public function update(Request $request, PpeppMonitoring $ppeppMonitoring)
    {
        $before = $ppeppMonitoring->toArray();
        $data = $this->validatedData($request);
        $data['completed_at'] = $data['status'] === 'selesai' ? now() : null;
        $ppeppMonitoring->update($data);
        ActivityLog::record('update', 'monitoring-ppepp', $ppeppMonitoring, $before, $ppeppMonitoring->fresh()->toArray());

        return redirect()->route('admin.ppepp-monitorings.index')->with('success', 'Monitoring PPEPP berhasil diperbarui.');
    }

    public function destroy(PpeppMonitoring $ppeppMonitoring)
    {
        ActivityLog::record('delete', 'monitoring-ppepp', $ppeppMonitoring, $ppeppMonitoring->toArray());
        $ppeppMonitoring->delete();

        return back()->with('success', 'Monitoring PPEPP berhasil dihapus.');
    }

    private function formData(PpeppMonitoring $monitoring): array
    {
        return [
            'monitoring' => $monitoring,
            'standards' => QualityStandard::where('is_active', true)->orderBy('code')->get(),
            'indicators' => QualityIndicator::with('standard')->orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ];
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'quality_standard_id' => ['nullable', 'exists:quality_standards,id'],
            'quality_indicator_id' => ['nullable', 'exists:quality_indicators,id'],
            'cycle' => ['required', 'in:Penetapan,Pelaksanaan,Evaluasi,Pengendalian,Peningkatan'],
            'period' => ['nullable', 'string', 'max:60'],
            'status' => ['required', 'in:draft,proses,selesai,terlambat'],
            'summary' => ['nullable', 'string'],
            'evidence' => ['nullable', 'string'],
            'owner_id' => ['nullable', 'exists:users,id'],
            'due_date' => ['nullable', 'date'],
        ]);
    }
}
