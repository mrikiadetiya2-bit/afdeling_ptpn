<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AfdelingSeeder::class,
            UserSeeder::class,
            BlockSeeder::class,
            WorkerSeeder::class,
            ActivitySeeder::class,
            HarvestSeeder::class,
            TargetSeeder::class,
            AttendanceSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
