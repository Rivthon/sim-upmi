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
    Schema::create('temuan_audits', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('audit_id');
        $table->text('deskripsi');
        $table->string('status')->default('belum ditindaklanjuti'); // atau 'selesai'
        $table->timestamps();

        $table->foreign('audit_id')->references('id')->on('audits')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temuan_audits');
    }
};
