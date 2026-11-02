<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('dokumen_mutus', 'revisi_dari')) {
            return;
        }

        Schema::table('dokumen_mutus', function (Blueprint $table) {
            $table->unsignedBigInteger('revisi_dari')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('dokumen_mutus', 'revisi_dari')) {
            return;
        }

        Schema::table('dokumen_mutus', function (Blueprint $table) {
            $table->dropColumn('revisi_dari');
        });
    }
};
