<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenMutu extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_dokumen',
        'judul',
        'kategori_dokumen_id',
        'sub_kategori_id',
        'versi',
        'tanggal_terbit',
        'file_path',
        'status',
        'approval_status',
        'approval_note',
        'approved_by',
        'approved_at',
        'uploaded_by',
        'revisi_dari',
        'deskripsi',
        'tipe',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function revisiDari()
    {
        return $this->belongsTo(DokumenMutu::class, 'revisi_dari');
    }

    public function revisiAnak()
    {
        return $this->hasMany(DokumenMutu::class, 'revisi_dari')->with('uploader');
    }

    public function dokumenAsal()
    {
        return $this->belongsTo(DokumenMutu::class, 'revisi_dari');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function versions()
    {
        return $this->hasMany(DocumentVersion::class, 'dokumen_mutu_id')->latest();
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_dokumen_id');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategoriDokumen::class, 'sub_kategori_id');
    }
}
