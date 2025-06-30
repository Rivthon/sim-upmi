<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAmi extends Model
{
    use HasFactory;

protected $fillable = [
    'judul', 'tahun', 'unit', 'sub_unit', 'tanggal_mulai',
    'tanggal_selesai', 'status', 'deskripsi', 'dibuat_oleh',
    'hasil_temuan', 'tindak_lanjut',
];



    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
 // di model JadwalAmi
public function auditors()
{
    return $this->belongsToMany(User::class, 'auditor_jadwal_ami', 'jadwal_ami_id', 'user_id');
}


}