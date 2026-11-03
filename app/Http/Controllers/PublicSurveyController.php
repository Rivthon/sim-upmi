<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublicSurveyController extends Controller
{
    public function show(Request $request, string $token)
    {
        $survey = Survey::with('questions')->where('public_token', $token)->firstOrFail();

        if (! $survey->isOpenForPublic()) {
            return response()->view('public.survey.closed', compact('survey'), 403);
        }

        $cookieName = $this->cookieName($survey);
        $respondentToken = $request->cookie($cookieName) ?: (string) Str::uuid();
        $alreadySubmitted = SurveyResponse::where('survey_id', $survey->id)
            ->where('respondent_token', $respondentToken)
            ->exists();

        $response = response()->view('public.survey.show', compact('survey', 'alreadySubmitted'));

        if (! $request->cookie($cookieName)) {
            $minutes = max(60, now()->diffInMinutes($survey->ends_at ?? now()->addDays(30), false) + 1440);
            $response->cookie($cookieName, $respondentToken, $minutes, '/', null, $request->isSecure(), true, false, 'Lax');
        }

        return $response;
    }

    public function store(Request $request, string $token)
    {
        $survey = Survey::with('questions')->where('public_token', $token)->firstOrFail();

        abort_unless($survey->isOpenForPublic(), 403, 'Masa pengisian survey sudah berakhir atau belum dimulai.');

        $respondentToken = $request->cookie($this->cookieName($survey));
        abort_unless($respondentToken && Str::isUuid($respondentToken), 419, 'Sesi survey tidak valid. Silakan buka ulang link survey.');

        if (SurveyResponse::where('survey_id', $survey->id)->where('respondent_token', $respondentToken)->exists()) {
            return back()->with('warning', 'Survey ini sudah pernah dikirim dari perangkat ini.');
        }

        $rules = [
            'respondent_name' => ['nullable', 'string', 'max:255'],
            'respondent_unit' => ['nullable', 'string', 'max:255'],
        ];

        foreach ($survey->questions as $question) {
            $rules["jawaban.{$question->id}"] = $question->tipe === 'ganda'
                ? ['required', 'array', 'min:1']
                : ['required'];
        }

        $validated = $request->validate($rules, [
            'jawaban.*.required' => 'Semua pertanyaan wajib dijawab.',
        ]);

        DB::transaction(function () use ($survey, $validated, $respondentToken) {
            foreach ($survey->questions as $question) {
                $answer = $validated['jawaban'][$question->id];

                SurveyResponse::create([
                    'survey_id' => $survey->id,
                    'question_id' => $question->id,
                    'user_id' => null,
                    'respondent_token' => $respondentToken,
                    'respondent_name' => $validated['respondent_name'] ?? null,
                    'respondent_unit' => $validated['respondent_unit'] ?? null,
                    'jawaban' => is_array($answer) ? json_encode($answer) : $answer,
                ]);
            }
        });

        return redirect()->route('survey.public.thanks', $survey->public_token);
    }

    public function thanks(string $token)
    {
        $survey = Survey::where('public_token', $token)->firstOrFail();

        return view('public.survey.thanks', compact('survey'));
    }

    private function cookieName(Survey $survey): string
    {
        return 'survey_respondent_'.$survey->id;
    }
}
