<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'quality_standard_id',
        'quality_indicator_id',
        'unit_name',
        'period',
        'target_value',
        'actual_value',
        'achievement_status',
        'analysis',
        'evidence',
        'pic',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
        'target_value' => 'decimal:2',
        'actual_value' => 'decimal:2',
    ];

    public function standard()
    {
        return $this->belongsTo(QualityStandard::class, 'quality_standard_id');
    }

    public function indicator()
    {
        return $this->belongsTo(QualityIndicator::class, 'quality_indicator_id');
    }
}
