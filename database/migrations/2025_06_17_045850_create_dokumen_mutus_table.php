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
        if (Schema::hasTable('dokumen_mutus')) {
            return;
        }

        Schema::create('dokumen_mutus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_dokumen');
            $table->string('judul');
            $table->foreignId('kategori_dokumen_id');
            $table->string('versi');
            $table->date('tanggal_terbit');
            $table->string('file_path');
            $table->enum('status', ['Aktif', 'Revisi', 'Tidak Berlaku'])->default('Aktif');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_mutus');
    }
};
