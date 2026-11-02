<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('dokumen_mutus', 'sub_kategori_id')) {
            Schema::table('dokumen_mutus', function (Blueprint $table) {
                $table->foreignId('sub_kategori_id')
                    ->nullable()
                    ->after('kategori_dokumen_id')
                    ->constrained('sub_kategori_dokumens')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('dokumen_mutus', 'deskripsi')) {
            Schema::table('dokumen_mutus', function (Blueprint $table) {
                $table->text('deskripsi')->nullable()->after('status');
            });
        }

        if (! Schema::hasColumn('dokumen_mutus', 'tipe')) {
            Schema::table('dokumen_mutus', function (Blueprint $table) {
                $table->enum('tipe', ['Publik', 'Internal'])->default('Internal')->after('deskripsi');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('dokumen_mutus', 'sub_kategori_id')) {
            Schema::table('dokumen_mutus', function (Blueprint $table) {
                $table->dropForeign(['sub_kategori_id']);
                $table->dropColumn('sub_kategori_id');
            });
        }

        foreach (['deskripsi', 'tipe'] as $column) {
            if (Schema::hasColumn('dokumen_mutus', $column)) {
                Schema::table('dokumen_mutus', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
