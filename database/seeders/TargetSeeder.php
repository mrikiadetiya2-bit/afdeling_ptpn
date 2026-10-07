<?php

namespace Database\Seeders;

use App\Models\Target;
use App\Models\Afdeling;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TargetSeeder extends Seeder
{
    public function run(): void
    {
        $afdelings = Afdeling::all();
        $currentYear = Carbon::now()->year;

        foreach ($afdelings as $afdeling) {
            for ($month = 1; $month <= 12; $month++) {
                Target::create([
                    'afdeling_id' => $afdeling->id,
                    'year' => $currentYear,
                    'month' => $month,
                    'target_kg' => rand(150000, 300000), // 150 - 300 ton per bulan
                ]);
            }
        }
    }
}
