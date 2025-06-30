<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    // Form tambah pertanyaan
    public function create(Survey $survey)
    {
        return view('admin.survey.pertanyaan.create', compact('survey'));
    }

    // Simpan pertanyaan ke database
    
    public function store(Request $request, Survey $survey)
    {
        $request->validate([
            'pertanyaan.*' => 'required|string',
            'tipe.*' => 'required|in:teks,skala,pilihan,ganda'
        ]);

        foreach ($request->pertanyaan as $index => $pertanyaan) {
            $tipe = $request->tipe[$index];
            $opsi = null;

            if (in_array($tipe, ['pilihan', 'ganda'])) {
                $opsiInput = $request->opsi[$index] ?? '';
                $opsi = array_map('trim', explode(',', $opsiInput));
            }

                SurveyQuestion::create([
    'survey_id' => $survey->id,
    'pertanyaan' => $pertanyaan,
    'tipe' => $tipe,
    'opsi' => $opsi ? json_encode($opsi) : null,
]);

        }

        return redirect()->route('admin.survey.show', $survey->id)
                         ->with('success', 'Pertanyaan berhasil ditambahkan!');
    }
    public function edit(Survey $survey, SurveyQuestion $pertanyaan)
{
    return view('admin.survey.pertanyaan.edit', compact('survey', 'pertanyaan'));
}
    public function update(Request $request, Survey $survey, SurveyQuestion $pertanyaan)
{
    $request->validate([
        'pertanyaan' => 'required|string',
        'tipe' => 'required|in:text,skala,pilihan,ganda',
    ]);

    $tipe = $request->tipe;
    $opsi = null;

    if (in_array($tipe, ['pilihan', 'ganda'])) {
        $opsiInput = $request->opsi ?? '';
        $opsi = array_map('trim', explode(',', $opsiInput));
    }

    $pertanyaan->update([
        'pertanyaan' => $request->pertanyaan,
        'tipe' => $tipe,
        'opsi' => $opsi,
    ]);

    return redirect()->route('admin.survey.show', $survey->id)
        ->with('success', 'Pertanyaan berhasil diperbarui!');
}
public function destroy(Survey $survey, SurveyQuestion $pertanyaan)
{
    $pertanyaan->delete();

    return redirect()
        ->route('admin.survey.show', $survey->id)
        ->with('success', 'Pertanyaan berhasil dihapus.');
}

}
