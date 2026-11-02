<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class LocalDatabaseSnapshotSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/local-database-snapshot.json');

        if (! File::exists($path)) {
            throw new RuntimeException('Snapshot tidak ditemukan: '.$path);
        }

        $snapshot = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        $tables = $snapshot['tables'] ?? [];

        $existing = collect(array_keys($tables))
            ->filter(fn (string $table) => Schema::hasTable($table) && DB::table($table)->exists())
            ->values();

        $allowMerge = filter_var(env('SNAPSHOT_SEED_ALLOW_MERGE', false), FILTER_VALIDATE_BOOL);

        if ($existing->isNotEmpty() && ! $allowMerge) {
            throw new RuntimeException(
                'Import dibatalkan karena tabel target sudah berisi data: '.$existing->join(', ').
                '. Gunakan database kosong atau set SNAPSHOT_SEED_ALLOW_MERGE=true untuk insert data yang belum ada.'
            );
        }

        Schema::disableForeignKeyConstraints();

        try {
            foreach ($tables as $table => $rows) {
                if (! Schema::hasTable($table)) {
                    $this->command?->warn("Tabel {$table} belum ada, dilewati.");
                    continue;
                }

                foreach (array_chunk($rows, 250) as $chunk) {
                    DB::table($table)->insertOrIgnore($chunk);
                }

                $this->command?->info(sprintf('%s: %d baris diproses', $table, count($rows)));
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        $this->command?->newLine();
        $this->command?->info('Snapshot database lokal selesai diproses.');
    }
}
