<?php

namespace App\Exports;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyExport implements FromArray, WithHeadings, WithTitle
{
    protected $survey;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->survey->questions as $question) {
            $responses = $question->responses;

            foreach ($responses as $response) {
                $userName = optional($response->user)->name ?? 'Anonim';
                $answer = $response->jawaban;

                // Decode jika JSON
                if ($question->tipe == 'ganda') {
                    $decoded = json_decode($answer, true);
                    $answer = is_array($decoded) ? implode(', ', $decoded) : $answer;
                }

                $data[] = [
                    'Pertanyaan' => $question->pertanyaan,
                    'Tipe' => $question->tipe,
                    'Jawaban' => $answer,
                    'User' => $userName,
                ];
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return ['Pertanyaan', 'Tipe', 'Jawaban', 'User'];
    }

    public function title(): string
    {
        return $this->survey->judul;
    }
}
