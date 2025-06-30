<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaporanSpmi extends Model
{
    use HasFactory;

protected $fillable = [
    'unit', // ← tambahkan ini
    'sub_unit',
    'judul',
    'periode',
    'tahapan',
    'deskripsi',
    'tanggal',
    'status',
    'bukti_pendukung',
    'created_by',
];



    protected $casts = [
        'tanggal' => 'date',
    ];
    // App\Models\PelaporanSpmi.php

public function creator()
{
    return $this->belongsTo(\App\Models\User::class, 'created_by');
}

}
