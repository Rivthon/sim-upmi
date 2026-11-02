<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ExportDatabaseSeeder extends Command
{
    protected $signature = 'snapshot:export-seeder';

    protected $description = 'Export application data into a JSON snapshot for LocalDatabaseSnapshotSeeder';

    public function handle(): int
    {
        $applicationTables = [
            'users',
            'permissions',
            'roles',
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'kategori_dokumen',
            'sub_kategori_dokumens',
            'dokumen_mutus',
            'document_versions',
            'audits',
            'temuan_audits',
            'pelaporan_spmis',
            'jadwal_amis',
            'auditor_jadwal_ami',
            'beritas',
            'surveys',
            'survey_targets',
            'survey_questions',
            'survey_question_options',
            'jawabans',
            'survey_responses',
            'site_contents',
            'app_notifications',
            'quality_standards',
            'quality_indicators',
            'ppepp_monitorings',
            'management_reviews',
            'capas',
            'quality_calendars',
            'quality_risks',
            'unit_monitorings',
            'accreditations',
            'quality_recommendations',
        ];

        $tables = collect($applicationTables)
            ->filter(fn (string $table) => Schema::hasTable($table))
            ->values();

        $snapshot = [
            'exported_at' => now()->toIso8601String(),
            'database' => DB::connection()->getDatabaseName(),
            'tables' => [],
        ];

        foreach ($tables as $table) {
            $query = DB::table($table);
            $orderColumn = $this->orderColumn($table);

            if ($orderColumn !== null) {
                $query->orderBy($orderColumn);
            }

            $rows = $query->get()
                ->map(fn (object $row) => (array) $row)
                ->all();

            $snapshot['tables'][$table] = $rows;
            $this->line(sprintf('%s: %d baris', $table, count($rows)));
        }

        $directory = database_path('seeders/data');
        File::ensureDirectoryExists($directory);
        $path = $directory.'/local-database-snapshot.json';
        File::put($path, json_encode($snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $this->newLine();
        $this->info('Snapshot dibuat: '.$path);
        $this->warn('File ini berisi data akun dan hash password. Simpan serta kirim melalui jalur aman.');

        return self::SUCCESS;
    }

    private function orderColumn(string $table): ?string
    {
        $columns = Schema::getColumnListing($table);

        return in_array('id', $columns, true) ? 'id' : ($columns[0] ?? null);
    }
}
