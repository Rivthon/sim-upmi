<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\QualityStandard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QualityStandardController extends Controller
{
    public function index()
    {
        $standards = QualityStandard::withCount('indicators')->latest()->get();

        return view('admin.quality-standards.index', compact('standards'));
    }

    public function create()
    {
        return view('admin.quality-standards.create', ['standard' => new QualityStandard(['is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $standard = QualityStandard::create($data);
        ActivityLog::record('create', 'standar-mutu', $standard, [], $standard->toArray());

        return redirect()->route('admin.quality-standards.index')->with('success', 'Standar mutu berhasil ditambahkan.');
    }

    public function edit(QualityStandard $qualityStandard)
    {
        return view('admin.quality-standards.edit', ['standard' => $qualityStandard]);
    }

    public function update(Request $request, QualityStandard $qualityStandard)
    {
        $before = $qualityStandard->toArray();
        $qualityStandard->update($this->validatedData($request, $qualityStandard));
        ActivityLog::record('update', 'standar-mutu', $qualityStandard, $before, $qualityStandard->fresh()->toArray());

        return redirect()->route('admin.quality-standards.index')->with('success', 'Standar mutu berhasil diperbarui.');
    }

    public function destroy(QualityStandard $qualityStandard)
    {
        ActivityLog::record('delete', 'standar-mutu', $qualityStandard, $qualityStandard->toArray());
        $qualityStandard->delete();

        return back()->with('success', 'Standar mutu berhasil dihapus.');
    }

    private function validatedData(Request $request, ?QualityStandard $standard = null): array
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:60', Rule::unique('quality_standards', 'code')->ignore($standard)],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
