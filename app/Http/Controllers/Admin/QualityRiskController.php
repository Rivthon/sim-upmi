<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\QualityRisk;
use App\Models\QualityStandard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QualityRiskController extends Controller
{
    public function index()
    {
        $risks = QualityRisk::with('standard')->latest()->get();

        return view('admin.quality-risks.index', compact('risks'));
    }

    public function create()
    {
        return view('admin.quality-risks.create', $this->formData(new QualityRisk([
            'likelihood' => 1,
            'impact' => 1,
            'status' => 'open',
        ])));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $risk = QualityRisk::create($this->withRiskScore($data));
        ActivityLog::record('create', 'risiko-mutu', $risk, [], $risk->toArray());

        return redirect()->route('admin.quality-risks.index')->with('success', 'Risiko mutu berhasil ditambahkan.');
    }

    public function edit(QualityRisk $qualityRisk)
    {
        return view('admin.quality-risks.edit', $this->formData($qualityRisk));
    }

    public function update(Request $request, QualityRisk $qualityRisk)
    {
        $before = $qualityRisk->toArray();
        $qualityRisk->update($this->withRiskScore($this->validatedData($request, $qualityRisk)));
        ActivityLog::record('update', 'risiko-mutu', $qualityRisk, $before, $qualityRisk->fresh()->toArray());

        return redirect()->route('admin.quality-risks.index')->with('success', 'Risiko mutu berhasil diperbarui.');
    }

    public function destroy(QualityRisk $qualityRisk)
    {
        ActivityLog::record('delete', 'risiko-mutu', $qualityRisk, $qualityRisk->toArray());
        $qualityRisk->delete();

        return back()->with('success', 'Risiko mutu berhasil dihapus.');
    }

    private function formData(QualityRisk $risk): array
    {
        return [
            'risk' => $risk,
            'standards' => QualityStandard::where('is_active', true)->orderBy('code')->get(),
        ];
    }

    private function validatedData(Request $request, ?QualityRisk $risk = null): array
    {
        return $request->validate([
            'quality_standard_id' => ['nullable', 'exists:quality_standards,id'],
            'unit_name' => ['nullable', 'string', 'max:255'],
            'risk_code' => ['required', 'string', 'max:60', Rule::unique('quality_risks', 'risk_code')->ignore($risk)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'likelihood' => ['required', 'integer', 'min:1', 'max:5'],
            'impact' => ['required', 'integer', 'min:1', 'max:5'],
            'mitigation' => ['nullable', 'string'],
            'pic' => ['nullable', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
            'status' => ['required', 'in:open,mitigasi,terkendali,closed'],
        ]);
    }

    private function withRiskScore(array $data): array
    {
        $data['risk_score'] = (int) $data['likelihood'] * (int) $data['impact'];
        $data['level'] = match (true) {
            $data['risk_score'] >= 16 => 'ekstrem',
            $data['risk_score'] >= 10 => 'tinggi',
            $data['risk_score'] >= 5 => 'sedang',
            default => 'rendah',
        };

        return $data;
    }
}
