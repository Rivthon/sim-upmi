<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_amis', function (Blueprint $table) {
            if (! Schema::hasColumn('jadwal_amis', 'status_tindak_lanjut')) {
                $table->string('status_tindak_lanjut', 30)->default('belum')->after('tindak_lanjut');
            }
            if (! Schema::hasColumn('jadwal_amis', 'target_selesai_tindak_lanjut')) {
                $table->date('target_selesai_tindak_lanjut')->nullable()->after('status_tindak_lanjut');
            }
            if (! Schema::hasColumn('jadwal_amis', 'selesai_tindak_lanjut_pada')) {
                $table->timestamp('selesai_tindak_lanjut_pada')->nullable()->after('target_selesai_tindak_lanjut');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_amis', function (Blueprint $table) {
            foreach (['status_tindak_lanjut', 'target_selesai_tindak_lanjut', 'selesai_tindak_lanjut_pada'] as $column) {
                if (Schema::hasColumn('jadwal_amis', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
