<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwal_amis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('unit');
            $table->string('tahun');
            $table->enum('status', ['Rencana', 'Selesai'])->default('Rencana');
            $table->unsignedBigInteger('dibuat_oleh');
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_amis');
    }
};
