<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaporan_spmis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('judul');
            $table->string('periode');
            $table->string('tahapan');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->enum('status', ['Draft', 'Final'])->default('Draft');
            $table->string('bukti_pendukung')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaporan_spmis');
    }
};
