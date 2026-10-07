<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Afdeling;
use App\Models\Block;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $afdelings = Afdeling::all();
        $types = ['Pemupukan', 'Penyemprotan Gulma', 'Tunas Pokok', 'Perbaikan Jalan'];

        foreach ($afdelings as $afdeling) {
            $blocks = Block::where('afdeling_id', $afdeling->id)->get();
            if ($blocks->isEmpty()) continue;

            for ($i = 0; $i < 20; $i++) {
                $block = $blocks->random();
                Activity::create([
                    'afdeling_id' => $afdeling->id,
                    'block_id' => $block->id,
                    'worker_id' => null,
                    'date' => Carbon::today()->subDays(rand(0, 30)),
                    'type' => $types[array_rand($types)],
                    'worker_count' => rand(2, 10),
                    'description' => 'Kegiatan rutin ' . strtolower($types[array_rand($types)]),
                    'result' => 'Selesai 100%',
                    'notes' => 'Tidak ada kendala',
                ]);
            }
        }
    }
}
