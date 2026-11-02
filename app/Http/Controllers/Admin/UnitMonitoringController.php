<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\QualityIndicator;
use App\Models\QualityStandard;
use App\Models\UnitMonitoring;
use Illuminate\Http\Request;

class UnitMonitoringController extends Controller
{
    public function index()
    {
        $monitorings = UnitMonitoring::with(['standard', 'indicator'])->latest()->get();

        return view('admin.unit-monitorings.index', compact('monitorings'));
    }

    public function create()
    {
        return view('admin.unit-monitorings.create', $this->formData(new UnitMonitoring([
            'achievement_status' => 'belum diukur',
        ])));
    }

    public function store(Request $request)
    {
        $monitoring = UnitMonitoring::create($this->validatedData($request));
        ActivityLog::record('create', 'monev-unit', $monitoring, [], $monitoring->toArray());

        return redirect()->route('admin.unit-monitorings.index')->with('success', 'Monev prodi/unit berhasil ditambahkan.');
    }

    public function edit(UnitMonitoring $unitMonitoring)
    {
        return view('admin.unit-monitorings.edit', $this->formData($unitMonitoring));
    }

    public function update(Request $request, UnitMonitoring $unitMonitoring)
    {
        $before = $unitMonitoring->toArray();
        $unitMonitoring->update($this->validatedData($request));
        ActivityLog::record('update', 'monev-unit', $unitMonitoring, $before, $unitMonitoring->fresh()->toArray());

        return redirect()->route('admin.unit-monitorings.index')->with('success', 'Monev prodi/unit berhasil diperbarui.');
    }

    public function destroy(UnitMonitoring $unitMonitoring)
    {
        ActivityLog::record('delete', 'monev-unit', $unitMonitoring, $unitMonitoring->toArray());
        $unitMonitoring->delete();

        return back()->with('success', 'Monev prodi/unit berhasil dihapus.');
    }

    private function formData(UnitMonitoring $monitoring): array
    {
        return [
            'monitoring' => $monitoring,
            'standards' => QualityStandard::where('is_active', true)->orderBy('code')->get(),
            'indicators' => QualityIndicator::with('standard')->latest()->get(),
        ];
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'quality_standard_id' => ['nullable', 'exists:quality_standards,id'],
            'quality_indicator_id' => ['nullable', 'exists:quality_indicators,id'],
            'unit_name' => ['required', 'string', 'max:255'],
            'period' => ['required', 'string', 'max:60'],
            'target_value' => ['nullable', 'numeric', 'min:0'],
            'actual_value' => ['nullable', 'numeric', 'min:0'],
            'achievement_status' => ['required', 'in:belum diukur,tercapai,tidak tercapai,perlu tindak lanjut'],
            'analysis' => ['nullable', 'string'],
            'evidence' => ['nullable', 'string'],
            'pic' => ['nullable', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
        ]);
    }
}
