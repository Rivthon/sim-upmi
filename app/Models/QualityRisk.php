<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'quality_standard_id',
        'unit_name',
        'risk_code',
        'title',
        'description',
        'likelihood',
        'impact',
        'risk_score',
        'level',
        'mitigation',
        'pic',
        'due_date',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function standard()
    {
        return $this->belongsTo(QualityStandard::class, 'quality_standard_id');
    }
}
