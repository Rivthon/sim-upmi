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
    Schema::table('users', function (Blueprint $table) {
        $table->date('tanggal_lahir')->nullable();
        $table->string('unit')->nullable();
        // Tidak perlu tambah `role` karena sudah pakai relasi dari spatie
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['tanggal_lahir', 'unit']);
    });
}

};
