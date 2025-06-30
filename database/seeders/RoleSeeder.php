<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin-upmi',
            'dosen',
            'gpm',              // GPM / Pengelola Prodi
            'auditor',
            'pimpinan',
            'tendik',
            'reviewer',
            'mahasiswa',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $this->command->info('Roles berhasil dibuat!');
    }
}
