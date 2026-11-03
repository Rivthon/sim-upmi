<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSurveyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $targets = $this->targetsFor($user);

        $surveys = Survey::with('responses')
            ->where('is_aktif', true)
            ->where(function ($query) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->whereHas('targets', function ($q) use ($targets) {
                $q->whereIn('target', $targets);
            })
            ->get();

        foreach ($surveys as $survey) {
            $survey->sudah_isi = $survey->responses->where('user_id', $user->id)->count() > 0;
        }

        return view('user.survey.index', compact('surveys'));
    }

    public function fill($id)
    {
        $survey = Survey::with(['questions', 'targets'])->findOrFail($id);

        abort_unless($this->canAccessSurvey($survey), 403, 'Anda tidak memiliki akses untuk mengisi survei ini.');

        foreach ($survey->questions as $question) {
            if (in_array($question->tipe, ['pilihan', 'ganda'])) {
                $question->opsi = is_array($question->opsi) ? $question->opsi : json_decode($question->opsi, true);
            }
        }

        $questions = SurveyQuestion::where('survey_id', $survey->id)->get();

        return view('user.survey.fill', compact('survey', 'questions'));
    }

    public function store(Request $request, $id)
    {
        $survey = Survey::with(['questions', 'targets'])->findOrFail($id);
        $userId = Auth::id();

        abort_unless($this->canAccessSurvey($survey), 403, 'Anda tidak memiliki akses untuk mengisi survei ini.');

        $existing = SurveyResponse::where('survey_id', $survey->id)
            ->where('user_id', $userId)
            ->exists();

        if ($existing) {
            return redirect()->route('user.survey.index')->with('warning', 'Anda sudah mengisi survei ini.');
        }

        foreach ($survey->questions as $question) {
            $jawaban = $request->input("jawaban.{$question->id}");

            if ($jawaban) {
                SurveyResponse::create([
                    'user_id' => $userId,
                    'survey_id' => $survey->id,
                    'question_id' => $question->id,
                    'jawaban' => is_array($jawaban) ? json_encode($jawaban) : $jawaban,
                ]);
            }
        }

        ActivityLog::record('submit', 'survey', $survey, [], [
            'judul' => $survey->judul,
            'user_id' => $userId,
            'total_questions' => $survey->questions->count(),
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Terima kasih, survei berhasil disimpan!');
    }

    private function canAccessSurvey(Survey $survey): bool
    {
        return $survey->isWithinSchedule() && $survey->targets
            ->pluck('target')
            ->intersect($this->targetsFor(Auth::user()))
            ->isNotEmpty();
    }

    private function targetsFor($user): array
    {
        return collect([
            'Umum',
            $user->hasRole('dosen') || $user->hasRole('gpm') ? 'Prodi' : null,
            $user->hasRole('tendik') ? 'Tendik' : null,
            $user->hasRole('mahasiswa') ? 'Mahasiswa' : null,
            $user->unit,
        ])->filter()->unique()->values()->all();
    }
}
