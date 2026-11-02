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
            $table->foreignId('survei_id')->constrained('surveys')->onDelete('cascade');
            $table->foreignId('pertanyaan_id')->constrained('survey_questions')->onDelete('cascade');
            $table->unsignedBigInteger('responden_id')->nullable();
            $table->string('responden_type')->nullable();
            $table->tinyInteger('skor')->nullable();
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
