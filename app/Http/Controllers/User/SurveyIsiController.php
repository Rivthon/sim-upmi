<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyIsiController extends Controller
{
    public function show(Survey $survey)
    {
        $user = Auth::user();

        // Validasi apakah user termasuk target survei
        $allowed = $survey->targets->pluck('target')->contains($user->role); // asumsinya role = 'Prodi', 'Tendik', etc
        if (!$allowed) abort(403, 'Anda tidak memiliki akses untuk mengisi survei ini.');

        $questions = $survey->questions;

        return view('user.survey.fill', compact('survey', 'questions'));
    }

public function store(Request $request, $id)
{
    $survey = Survey::with('questions')->findOrFail($id);

    // Cek apakah user sudah mengisi survei ini sebelumnya
    $existing = SurveyResponse::where('survey_id', $survey->id)
                    ->where('user_id', Auth::id())
                    ->exists();

    if ($existing) {
        return redirect()->route('user.survey.index')->with('warning', 'Anda sudah mengisi survei ini.');
    }

    // Simpan jawaban satu per satu
foreach ($survey->questions as $question) {
    // Default: ambil dari jawaban[]
    $jawaban = $request->input('jawaban.' . $question->id);

    // Jika tipe ganda, ambil dari input 'jawaban_{id}[]'
    if ($question->tipe == 'ganda') {
        $jawabanArray = $request->input('jawaban_' . $question->id, []);
        $jawaban = json_encode($jawabanArray);
    }

    SurveyResponse::create([
        'survey_id' => $survey->id,
        'question_id' => $question->id,
        'user_id' => Auth::id(),
        'jawaban' => $jawaban,
    ]);
}


    return redirect()->route('user.survey.index')->with('success', 'Terima kasih, survei telah berhasil dikirim.');
}
}
