<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'kategori_dokumen_id',
        'sub_kategori_id',
        'tipe',
        'kode_dokumen',
        'versi',
        'tanggal_terbit',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_dokumen_id');
    }

    public function subKategori()
    {
        return $this->belongsTo(SubKategoriDokumen::class, 'sub_kategori_id');
    }
}
