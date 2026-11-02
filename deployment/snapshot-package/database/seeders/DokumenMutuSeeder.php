<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DokumenMutu;
use App\Models\User;

class DokumenMutuSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'adminupmi@stikesbh.ac.id')->first();
        if (!$admin) return;

        DokumenMutu::create([
            'kode_dokumen' => 'SOP-UPMI-01',
            'judul' => 'SOP Pengelolaan Dokumen Mutu',
            'kategori_dokumen_id' => 2,
            'versi' => '1.0',
            'tanggal_terbit' => now(),
            'file_path' => 'dummy.pdf',
            'status' => 'Aktif',
            'uploaded_by' => $admin->id
        ]);
    }
}
