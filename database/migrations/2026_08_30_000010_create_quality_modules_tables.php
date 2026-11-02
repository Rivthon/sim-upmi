<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quality_standards', function (Blueprint $table) {
            $table->id();
            $table->string('code', 60)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('quality_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_standard_id')->constrained('quality_standards')->cascadeOnDelete();
            $table->string('name');
            $table->string('unit', 60)->nullable();
            $table->decimal('target_value', 10, 2)->nullable();
            $table->decimal('actual_value', 10, 2)->nullable();
            $table->string('status', 30)->default('belum diukur');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('ppepp_monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_standard_id')->nullable()->constrained('quality_standards')->nullOnDelete();
            $table->foreignId('quality_indicator_id')->nullable()->constrained('quality_indicators')->nullOnDelete();
            $table->string('cycle', 30);
            $table->string('period', 60)->nullable();
            $table->string('status', 30)->default('draft');
            $table->text('summary')->nullable();
            $table->text('evidence')->nullable();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('management_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('meeting_date');
            $table->string('location')->nullable();
            $table->text('agenda')->nullable();
            $table->text('participants')->nullable();
            $table->text('notes')->nullable();
            $table->text('decisions')->nullable();
            $table->string('status', 30)->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('capas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_review_id')->nullable()->constrained('management_reviews')->nullOnDelete();
            $table->foreignId('jadwal_ami_id')->nullable()->constrained('jadwal_amis')->nullOnDelete();
            $table->string('title');
            $table->text('root_cause')->nullable();
            $table->text('corrective_action')->nullable();
            $table->text('preventive_action')->nullable();
            $table->text('effectiveness_check')->nullable();
            $table->string('pic')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status', 30)->default('open');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('quality_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category', 60)->default('umum');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 30)->default('terjadwal');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quality_calendars');
        Schema::dropIfExists('capas');
        Schema::dropIfExists('management_reviews');
        Schema::dropIfExists('ppepp_monitorings');
        Schema::dropIfExists('quality_indicators');
        Schema::dropIfExists('quality_standards');
    }
};
