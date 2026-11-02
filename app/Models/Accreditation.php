<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'agency',
        'instrument',
        'current_rank',
        'target_rank',
        'submission_date',
        'assessment_date',
        'expiry_date',
        'document_progress',
        'pic',
        'status',
        'notes',
    ];

    protected $casts = [
        'submission_date' => 'date',
        'assessment_date' => 'date',
        'expiry_date' => 'date',
    ];
}
