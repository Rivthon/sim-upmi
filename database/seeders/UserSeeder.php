<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'adminupmi@stikesbh.ac.id'],
            [
                'name' => 'Admin UPMI',
                'password' => Hash::make('password'), // ganti password default sesuai kebutuhan
            ]
        );

        $admin->assignRole('admin-upmi');

        $this->command->info('User Admin UPMI berhasil dibuat dan diberikan role.');
    }
}
