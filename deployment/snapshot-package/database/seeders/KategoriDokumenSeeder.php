<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriDokumen;

class KategoriDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = ['Pedoman', 'SOP', 'Instruksi Kerja', 'Formulir', 'Kebijakan'];

        foreach ($kategori as $k) {
            KategoriDokumen::create(['nama' => $k]);
        }
    }
}
