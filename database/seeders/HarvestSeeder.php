<?php

namespace Database\Seeders;

use App\Models\Harvest;
use App\Models\Afdeling;
use App\Models\Block;
use App\Models\Worker;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HarvestSeeder extends Seeder
{
    public function run(): void
    {
        $afdelings = Afdeling::all();

        foreach ($afdelings as $afdeling) {
            $blocks = Block::where('afdeling_id', $afdeling->id)->get();
            $workers = Worker::where('afdeling_id', $afdeling->id)->where('position', 'Pemanen')->get();
            if ($blocks->isEmpty() || $workers->isEmpty()) continue;

            for ($i = 0; $i < 30; $i++) {
                $bunch_count = rand(50, 200);
                $weight = $bunch_count * rand(15, 25); // Asumsi 1 janjang = 15-25kg

                Harvest::create([
                    'afdeling_id' => $afdeling->id,
                    'block_id' => $blocks->random()->id,
                    'worker_id' => $workers->random()->id,
                    'date' => Carbon::today()->subDays(rand(0, 30)),
                    'bunch_count' => $bunch_count,
                    'weight_kg' => $weight,
                    'notes' => 'Panen harian',
                ]);
            }
        }
    }
}
