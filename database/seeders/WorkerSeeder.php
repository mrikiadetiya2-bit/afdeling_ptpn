<?php

namespace Database\Seeders;

use App\Models\Worker;
use App\Models\Afdeling;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    public function run(): void
    {
        $afdelings = Afdeling::all();
        $positions = ['Pemanen', 'Perawatan', 'Tukang Muat'];
        $faker = \Faker\Factory::create('id_ID');

        foreach ($afdelings as $afdeling) {
            for ($i = 1; $i <= 10; $i++) {
                Worker::create([
                    'afdeling_id' => $afdeling->id,
                    'employee_id' => 'EMP-' . str_pad($afdeling->id, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'name' => $faker->name,
                    'position' => $positions[array_rand($positions)],
                    'status' => rand(0, 1) ? 'tetap' : 'tidak_tetap',
                ]);
            }
        }
    }
}
