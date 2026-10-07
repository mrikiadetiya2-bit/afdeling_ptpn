<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\Afdeling;
use Illuminate\Database\Seeder;

class BlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $afdelings = Afdeling::all();
        
        foreach ($afdelings as $afdeling) {
            for ($i = 1; $i <= 5; $i++) {
                Block::create([
                    'afdeling_id' => $afdeling->id,
                    'code' => $afdeling->code . '-B0' . $i,
                    'name' => 'Blok ' . $i . ' ' . $afdeling->name,
                    'area_hectares' => rand(10, 50) + (rand(0, 99) / 100),
                    'total_trees' => rand(1300, 6500),
                    'planting_year' => rand(2010, 2020),
                ]);
            }
        }
    }
}
