<?php

namespace Database\Seeders;

use App\Models\Afdeling;
use Illuminate\Database\Seeder;

class AfdelingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $afdelings = [
            [
                'name' => 'Afdeling 1',
                'code' => 'AFD-1',
                'description' => 'Wilayah Afdeling 1 meliputi blok barat.',
                'area_hectares' => 250.50,
                'center_lat' => -3.812345,
                'center_lng' => 114.773456,
                'assistant_name' => 'Budi Santoso',
            ],
            [
                'name' => 'Afdeling 2',
                'code' => 'AFD-2',
                'description' => 'Wilayah Afdeling 2 meliputi blok utara.',
                'area_hectares' => 210.20,
                'center_lat' => -3.815678,
                'center_lng' => 114.775678,
                'assistant_name' => 'Agus Yulianto',
            ],
            [
                'name' => 'Afdeling 3',
                'code' => 'AFD-3',
                'description' => 'Wilayah Afdeling 3 meliputi blok timur.',
                'area_hectares' => 300.00,
                'center_lat' => -3.818901,
                'center_lng' => 114.778901,
                'assistant_name' => 'Hendra Setiawan',
            ],
            [
                'name' => 'Afdeling 4',
                'code' => 'AFD-4',
                'description' => 'Wilayah Afdeling 4 meliputi blok selatan.',
                'area_hectares' => 180.75,
                'center_lat' => -3.821234,
                'center_lng' => 114.781234,
                'assistant_name' => 'Fajar Nugroho',
            ],
        ];

        foreach ($afdelings as $data) {
            Afdeling::create($data);
        }
    }
}
