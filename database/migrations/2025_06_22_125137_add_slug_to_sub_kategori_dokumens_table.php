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
    Schema::table('sub_kategori_dokumens', function (Blueprint $table) {
        $table->string('slug')->nullable()->after('nama'); // atau bisa ->unique() kalau perlu
    });
}

public function down()
{
    Schema::table('sub_kategori_dokumens', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
}

};
