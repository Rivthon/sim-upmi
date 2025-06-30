<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriDokumen extends Model
{
    protected $table = 'kategori_dokumen';

    protected $fillable = [
        'nama',
        'tipe',
        'deskripsi',
        'parent_id',
    ];
public function dokumenMutus()
{
    return $this->hasMany(DokumenMutu::class, 'kategori_dokumen_id');
}
    // Relasi: Kategori induk (parent)
    public function parent()
    {
        return $this->belongsTo(KategoriDokumen::class, 'parent_id');
    }

    // Relasi: Sub-kategori (child)
    public function children()
    {
        return $this->hasMany(KategoriDokumen::class, 'parent_id');
    }
    public function subKategoris()
{
    return $this->hasMany(SubKategoriDokumen::class);
}

}
