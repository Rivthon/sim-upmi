<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumen_mutu_id')->constrained('dokumen_mutus')->cascadeOnDelete();
            $table->string('version_label', 50);
            $table->string('file_path')->nullable();
            $table->json('snapshot')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['dokumen_mutu_id', 'version_label']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_versions');
    }
};
