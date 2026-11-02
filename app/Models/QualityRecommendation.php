<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'title',
        'description',
        'unit_name',
        'pic',
        'due_date',
        'priority',
        'status',
        'follow_up',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];
}
