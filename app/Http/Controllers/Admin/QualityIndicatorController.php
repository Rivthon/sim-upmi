<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\QualityIndicator;
use App\Models\QualityStandard;
use Illuminate\Http\Request;

class QualityIndicatorController extends Controller
{
    public function index()
    {
        $indicators = QualityIndicator::with('standard')->latest()->get();

        return view('admin.quality-indicators.index', compact('indicators'));
    }

    public function create()
    {
        return view('admin.quality-indicators.create', $this->formData(new QualityIndicator(['status' => 'belum diukur'])));
    }

    public function store(Request $request)
    {
        $indicator = QualityIndicator::create($this->validatedData($request));
        ActivityLog::record('create', 'indikator-mutu', $indicator, [], $indicator->toArray());

        return redirect()->route('admin.quality-indicators.index')->with('success', 'Indikator mutu berhasil ditambahkan.');
    }

    public function edit(QualityIndicator $qualityIndicator)
    {
        return view('admin.quality-indicators.edit', $this->formData($qualityIndicator));
    }

    public function update(Request $request, QualityIndicator $qualityIndicator)
    {
        $before = $qualityIndicator->toArray();
        $qualityIndicator->update($this->validatedData($request));
        ActivityLog::record('update', 'indikator-mutu', $qualityIndicator, $before, $qualityIndicator->fresh()->toArray());

        return redirect()->route('admin.quality-indicators.index')->with('success', 'Indikator mutu berhasil diperbarui.');
    }

    public function destroy(QualityIndicator $qualityIndicator)
    {
        ActivityLog::record('delete', 'indikator-mutu', $qualityIndicator, $qualityIndicator->toArray());
        $qualityIndicator->delete();

        return back()->with('success', 'Indikator mutu berhasil dihapus.');
    }

    private function formData(QualityIndicator $indicator): array
    {
        return [
            'indicator' => $indicator,
            'standards' => QualityStandard::where('is_active', true)->orderBy('code')->get(),
        ];
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'quality_standard_id' => ['required', 'exists:quality_standards,id'],
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:60'],
            'target_value' => ['nullable', 'numeric'],
            'actual_value' => ['nullable', 'numeric'],
            'status' => ['required', 'in:belum diukur,tercapai,tidak tercapai'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
