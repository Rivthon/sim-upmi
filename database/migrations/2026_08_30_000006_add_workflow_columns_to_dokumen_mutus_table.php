<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen_mutus', function (Blueprint $table) {
            if (! Schema::hasColumn('dokumen_mutus', 'approval_status')) {
                $table->string('approval_status', 30)->default('pending')->after('status');
            }
            if (! Schema::hasColumn('dokumen_mutus', 'approval_note')) {
                $table->text('approval_note')->nullable()->after('approval_status');
            }
            if (! Schema::hasColumn('dokumen_mutus', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('approval_note')->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('dokumen_mutus', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
        });

        DB::table('dokumen_mutus')
            ->where('approval_status', 'pending')
            ->update([
                'approval_status' => 'approved',
                'approved_at' => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('dokumen_mutus', function (Blueprint $table) {
            foreach (['approved_by'] as $column) {
                if (Schema::hasColumn('dokumen_mutus', $column)) {
                    $table->dropConstrainedForeignId($column);
                }
            }

            foreach (['approval_status', 'approval_note', 'approved_at'] as $column) {
                if (Schema::hasColumn('dokumen_mutus', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
