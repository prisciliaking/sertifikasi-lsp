<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UtilityRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        UtilityRole::firstOrCreate(['role_name' => 'admin']);
        UtilityRole::firstOrCreate(['role_name' => 'penyewa']);

        User::firstOrCreate(
            ['nik' => 3578000000000001],
            [
                'nama_lengkap' => 'Administrator Garasi',
                'no_hp' => '081234567890',
                'email' => 'admin@sewagarasi.com',
                'password' => Hash::make('admin123'),
                'status_validasi' => 'diterima',
                'role_name' => 'admin',
            ]
        );
    }
}
