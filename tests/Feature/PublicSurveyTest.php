<?php

namespace Tests\Feature;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicSurveyTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_survey_can_be_submitted_without_login_during_active_period(): void
    {
        $survey = Survey::create([
            'judul' => 'Survey Publik',
            'is_aktif' => true,
            'is_public' => true,
            'starts_at' => now()->subHour(),
            'ends_at' => now()->addDays(2),
        ]);
        $question = SurveyQuestion::create([
            'survey_id' => $survey->id,
            'pertanyaan' => 'Apakah Anda puas?',
            'tipe' => 'skala',
        ]);
        $respondentToken = (string) Str::uuid();

        $response = $this
            ->withCookie('survey_respondent_'.$survey->id, $respondentToken)
            ->post(route('survey.public.store', $survey->public_token), [
                'respondent_name' => 'Responden',
                'jawaban' => [$question->id => '5'],
            ]);

        $response->assertRedirect(route('survey.public.thanks', $survey->public_token));
        $this->assertDatabaseHas('survey_responses', [
            'survey_id' => $survey->id,
            'question_id' => $question->id,
            'user_id' => null,
            'respondent_token' => $respondentToken,
            'jawaban' => '5',
        ]);
    }

    public function test_expired_public_survey_rejects_page_and_submission(): void
    {
        $survey = Survey::create([
            'judul' => 'Survey Kedaluwarsa',
            'is_aktif' => true,
            'is_public' => true,
            'starts_at' => now()->subDays(3),
            'ends_at' => now()->subDay(),
        ]);
        $question = SurveyQuestion::create([
            'survey_id' => $survey->id,
            'pertanyaan' => 'Pertanyaan',
            'tipe' => 'teks',
        ]);

        $this->get(route('survey.public.show', $survey->public_token))->assertForbidden();

        $this
            ->withCookie('survey_respondent_'.$survey->id, (string) Str::uuid())
            ->post(route('survey.public.store', $survey->public_token), [
                'jawaban' => [$question->id => 'Dipaksa'],
            ])
            ->assertForbidden();

        $this->assertSame(0, SurveyResponse::count());
    }
}
