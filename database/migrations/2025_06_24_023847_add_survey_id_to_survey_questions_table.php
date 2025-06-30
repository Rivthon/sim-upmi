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
    Schema::table('survey_questions', function (Blueprint $table) {
        $table->foreignId('survey_id')->constrained()->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('survey_questions', function (Blueprint $table) {
        $table->dropForeign(['survey_id']);
        $table->dropColumn('survey_id');
    });
}

};
