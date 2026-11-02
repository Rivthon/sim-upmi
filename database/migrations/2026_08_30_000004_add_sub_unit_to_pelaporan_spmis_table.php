<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pelaporan_spmis') && ! Schema::hasColumn('pelaporan_spmis', 'sub_unit')) {
            Schema::table('pelaporan_spmis', function (Blueprint $table) {
                $table->string('sub_unit')->nullable()->after('unit');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pelaporan_spmis') && Schema::hasColumn('pelaporan_spmis', 'sub_unit')) {
            Schema::table('pelaporan_spmis', function (Blueprint $table) {
                $table->dropColumn('sub_unit');
            });
        }
    }
};
