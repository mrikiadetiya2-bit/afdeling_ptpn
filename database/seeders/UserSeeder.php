<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin SIMAF',
            'email' => 'admin@ptpn.co.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Pimpinan
        User::create([
            'name' => 'Pimpinan Regional V',
            'email' => 'pimpinan@ptpn.co.id',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
        ]);

        // Asisten & Mandor Afdeling 1
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'asisten.afd1@ptpn.co.id',
            'password' => Hash::make('password'),
            'role' => 'asisten',
            'afdeling_id' => 1,
        ]);
        User::create([
            'name' => 'Supriadi',
            'email' => 'mandor.afd1@ptpn.co.id',
            'password' => Hash::make('password'),
            'role' => 'mandor',
            'afdeling_id' => 1,
        ]);
    }
}
