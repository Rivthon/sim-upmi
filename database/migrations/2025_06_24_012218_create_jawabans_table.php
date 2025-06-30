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
Schema::create('jawabans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('survei_id')->constrained()->onDelete('cascade');
    $table->foreignId('pertanyaan_id')->constrained()->onDelete('cascade');
    $table->unsignedBigInteger('responden_id')->nullable(); // Bisa mahasiswa/tendik/prodi, tergantung sistem login
    $table->string('responden_type')->nullable(); // Mahasiswa / Tendik / Prodi (polymorphic-like)
    $table->tinyInteger('skor')->nullable(); // 1-5, atau 1-10
    $table->text('komentar')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
