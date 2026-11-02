<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capa extends Model
{
    use HasFactory;

    protected $fillable = ['management_review_id', 'jadwal_ami_id', 'title', 'root_cause', 'corrective_action', 'preventive_action', 'effectiveness_check', 'pic', 'due_date', 'status', 'closed_at'];

    protected $casts = ['due_date' => 'date', 'closed_at' => 'datetime'];

    public function managementReview()
    {
        return $this->belongsTo(ManagementReview::class);
    }

    public function ami()
    {
        return $this->belongsTo(JadwalAmi::class, 'jadwal_ami_id');
    }
}
