<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\QualityRecommendation;
use Illuminate\Http\Request;

class QualityRecommendationController extends Controller
{
    public function index()
    {
        $recommendations = QualityRecommendation::latest()->get();

        return view('admin.recommendations.index', compact('recommendations'));
    }

    public function create()
    {
        return view('admin.recommendations.create', ['recommendation' => new QualityRecommendation([
            'source' => 'umum',
            'priority' => 'sedang',
            'status' => 'open',
        ])]);
    }

    public function store(Request $request)
    {
        $recommendation = QualityRecommendation::create($this->withCompletedAt($this->validatedData($request)));
        ActivityLog::record('create', 'rekomendasi-mutu', $recommendation, [], $recommendation->toArray());

        return redirect()->route('admin.recommendations.index')->with('success', 'Rekomendasi berhasil ditambahkan.');
    }

    public function edit(QualityRecommendation $recommendation)
    {
        return view('admin.recommendations.edit', compact('recommendation'));
    }

    public function update(Request $request, QualityRecommendation $recommendation)
    {
        $before = $recommendation->toArray();
        $recommendation->update($this->withCompletedAt($this->validatedData($request), $recommendation));
        ActivityLog::record('update', 'rekomendasi-mutu', $recommendation, $before, $recommendation->fresh()->toArray());

        return redirect()->route('admin.recommendations.index')->with('success', 'Rekomendasi berhasil diperbarui.');
    }

    public function destroy(QualityRecommendation $recommendation)
    {
        ActivityLog::record('delete', 'rekomendasi-mutu', $recommendation, $recommendation->toArray());
        $recommendation->delete();

        return back()->with('success', 'Rekomendasi berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'source' => ['required', 'in:ami,rtm,survey,ppepp,monev,risiko,akreditasi,umum'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'unit_name' => ['nullable', 'string', 'max:255'],
            'pic' => ['nullable', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
            'priority' => ['required', 'in:rendah,sedang,tinggi,kritis'],
            'status' => ['required', 'in:open,proses,selesai,ditunda'],
            'follow_up' => ['nullable', 'string'],
        ]);
    }

    private function withCompletedAt(array $data, ?QualityRecommendation $recommendation = null): array
    {
        $data['completed_at'] = $data['status'] === 'selesai'
            ? ($recommendation?->completed_at ?? now())
            : null;

        return $data;
    }
}
