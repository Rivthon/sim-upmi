<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_standard_id')->nullable()->constrained('quality_standards')->nullOnDelete();
            $table->string('unit_name')->nullable();
            $table->string('risk_code', 60)->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('likelihood')->default(1);
            $table->unsignedTinyInteger('impact')->default(1);
            $table->unsignedTinyInteger('risk_score')->default(1);
            $table->string('level', 30)->default('rendah');
            $table->text('mitigation')->nullable();
            $table->string('pic')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status', 30)->default('open');
            $table->timestamps();
        });

        Schema::create('unit_monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_standard_id')->nullable()->constrained('quality_standards')->nullOnDelete();
            $table->foreignId('quality_indicator_id')->nullable()->constrained('quality_indicators')->nullOnDelete();
            $table->string('unit_name');
            $table->string('period', 60);
            $table->decimal('target_value', 10, 2)->nullable();
            $table->decimal('actual_value', 10, 2)->nullable();
            $table->string('achievement_status', 30)->default('belum diukur');
            $table->text('analysis')->nullable();
            $table->text('evidence')->nullable();
            $table->string('pic')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });

        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->string('agency')->nullable();
            $table->string('instrument')->nullable();
            $table->string('current_rank', 60)->nullable();
            $table->string('target_rank', 60)->nullable();
            $table->date('submission_date')->nullable();
            $table->date('assessment_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->unsignedTinyInteger('document_progress')->default(0);
            $table->string('pic')->nullable();
            $table->string('status', 30)->default('persiapan');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('quality_recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('source', 60)->default('umum');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('pic')->nullable();
            $table->date('due_date')->nullable();
            $table->string('priority', 30)->default('sedang');
            $table->string('status', 30)->default('open');
            $table->text('follow_up')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_recommendations');
        Schema::dropIfExists('accreditations');
        Schema::dropIfExists('unit_monitorings');
        Schema::dropIfExists('quality_risks');
    }
};
