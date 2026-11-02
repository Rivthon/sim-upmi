<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('dokumen_mutus') || ! Schema::hasTable('kategori_dokumen')) {
            return;
        }

        $hasOrphanedRows = DB::table('dokumen_mutus')
            ->leftJoin('kategori_dokumen', 'dokumen_mutus.kategori_dokumen_id', '=', 'kategori_dokumen.id')
            ->whereNotNull('dokumen_mutus.kategori_dokumen_id')
            ->whereNull('kategori_dokumen.id')
            ->exists();

        if ($hasOrphanedRows) {
            return;
        }

        Schema::table('dokumen_mutus', function (Blueprint $table) {
            $table->foreign('kategori_dokumen_id')
                ->references('id')
                ->on('kategori_dokumen')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_mutus', function (Blueprint $table) {
            $table->dropForeign(['kategori_dokumen_id']);
        });
    }
};
