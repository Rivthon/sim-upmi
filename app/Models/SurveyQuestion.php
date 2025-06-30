<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $fillable = ['survey_id', 'pertanyaan', 'tipe', 'opsi'];

    protected $casts = [
        'opsi' => 'array',
    ];

public function survey()
{
    return $this->belongsTo(Survey::class);
}
public function responses()
{
    return $this->hasMany(SurveyResponse::class, 'question_id');
}

}
