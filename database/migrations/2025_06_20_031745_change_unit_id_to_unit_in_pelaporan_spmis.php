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
    Schema::table('pelaporan_spmis', function (Blueprint $table) {
        $table->dropColumn('unit_id');
        $table->string('unit')->after('id');
    });
}

public function down()
{
    Schema::table('pelaporan_spmis', function (Blueprint $table) {
        $table->dropColumn('unit');
        $table->unsignedBigInteger('unit_id')->nullable();
    });
}

};
