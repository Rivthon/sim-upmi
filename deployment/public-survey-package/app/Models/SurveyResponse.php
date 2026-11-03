<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'question_id',
        'user_id',
        'respondent_token',
        'respondent_name',
        'respondent_unit',
        'jawaban',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
