<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->uuid('public_token')->nullable()->unique()->after('id');
            $table->boolean('is_public')->default(false)->after('is_aktif');
            $table->dateTime('starts_at')->nullable()->after('is_public');
            $table->dateTime('ends_at')->nullable()->after('starts_at');
        });

        Schema::table('survey_responses', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->uuid('respondent_token')->nullable()->after('user_id');
            $table->string('respondent_name')->nullable()->after('respondent_token');
            $table->string('respondent_unit')->nullable()->after('respondent_name');
            $table->unique(
                ['survey_id', 'question_id', 'respondent_token'],
                'survey_responses_unique_public_answer'
            );
        });
    }

    public function down(): void
    {
        Schema::table('survey_responses', function (Blueprint $table) {
            $table->dropUnique('survey_responses_unique_public_answer');
            $table->dropColumn(['respondent_token', 'respondent_name', 'respondent_unit']);
            $table->foreignId('user_id')->nullable(false)->change();
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->dropUnique(['public_token']);
            $table->dropColumn(['public_token', 'is_public', 'starts_at', 'ends_at']);
        });
    }
};
