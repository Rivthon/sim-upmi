<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpeppMonitoring extends Model
{
    use HasFactory;

    protected $fillable = ['quality_standard_id', 'quality_indicator_id', 'cycle', 'period', 'status', 'summary', 'evidence', 'owner_id', 'due_date', 'completed_at'];

    protected $casts = ['due_date' => 'date', 'completed_at' => 'datetime'];

    public function standard()
    {
        return $this->belongsTo(QualityStandard::class, 'quality_standard_id');
    }

    public function indicator()
    {
        return $this->belongsTo(QualityIndicator::class, 'quality_indicator_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
