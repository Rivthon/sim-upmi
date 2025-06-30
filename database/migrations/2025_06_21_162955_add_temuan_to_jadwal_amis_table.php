<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('jadwal_amis', function (Blueprint $table) {
        $table->text('hasil_temuan')->nullable();
        $table->text('tindak_lanjut')->nullable();
    });
}

public function down()
{
    Schema::table('jadwal_amis', function (Blueprint $table) {
        $table->dropColumn(['hasil_temuan', 'tindak_lanjut']);
    });
}

};
