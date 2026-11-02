<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('beritas') && ! Schema::hasColumn('beritas', 'slug')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('judul');
            });
        }

        if (Schema::hasTable('jadwal_amis') && ! Schema::hasColumn('jadwal_amis', 'deskripsi')) {
            Schema::table('jadwal_amis', function (Blueprint $table) {
                $table->text('deskripsi')->nullable()->after('judul');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('jadwal_amis') && Schema::hasColumn('jadwal_amis', 'deskripsi')) {
            Schema::table('jadwal_amis', function (Blueprint $table) {
                $table->dropColumn('deskripsi');
            });
        }

        if (Schema::hasTable('beritas') && Schema::hasColumn('beritas', 'slug')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
