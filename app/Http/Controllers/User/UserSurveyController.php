<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SurveyQuestion;

class UserSurveyController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Cek target sesuai role
    if ($user->hasRole('Prodi')) {
        $target = 'Prodi';
    } elseif ($user->hasRole('Tendik')) {
        $target = 'Tendik';
    } elseif ($user->hasRole('Mahasiswa')) {
        $target = 'Mahasiswa';
    } else {
        $target = null;
    }

    // Ambil survei sesuai target
    $surveys = Survey::whereHas('targets', function ($q) {
    $q->where('target', 'Tendik');
})->get(); // ✅ Ini benar

     foreach ($surveys as $survey) {
        $survey->sudah_isi = $survey->responses->where('user_id', $user->id)->count() > 0;
    }
    return view('user.survey.index', compact('surveys'));
}

   // public function index()
// {
//     $user = auth()->user();
//     $unit = $user->unit; // Misal "Tendik", "Prodi S1 Farmasi", dst

//     $surveys = Survey::whereHas('targets', function ($q) use ($unit) {
//         $q->where('target', $unit);
//     })->with('responses')->get();

//     foreach ($surveys as $survey) {
//         $survey->sudah_isi = $survey->responses->where('user_id', $user->id)->count() > 0;
//     }

//     return view('user.survey.index', compact('surveys'));
// }


    // Form isi survei
public function fill($id)
{
        $survey = Survey::with('questions')->findOrFail($id);

    foreach ($survey->questions as $q) {
        if (in_array($q->tipe, ['pilihan', 'ganda'])) {
            $q->opsi = json_decode($q->opsi, true);
        }
    }
    $questions = SurveyQuestion::where('survey_id', $survey->id)->get();

    return view('user.survey.fill', compact('survey', 'questions'));
}

    // Simpan jawaban survei
    public function store(Request $request, $id)
    {
        $survey = Survey::with('questions')->findOrFail($id);
        $userId = Auth::id();

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

        return redirect()->route('user.dashboard')->with('success', 'Terima kasih, survei berhasil disimpan!');
    }
}
