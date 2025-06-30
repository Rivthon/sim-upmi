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
        Schema::table('dokumen_mutus', function (Blueprint $table) {
$table->unsignedBigInteger('revisi_dari')->nullable(); // relasi ke dokumen lama

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen_mutus', function (Blueprint $table) {
            //
        });
    }
};
