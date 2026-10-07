<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Afdeling;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $afdelings = Afdeling::all();
        $admin = User::where('role', 'admin')->first();
        if (!$admin) return;

        foreach ($afdelings as $afdeling) {
            Report::create([
                'afdeling_id' => $afdeling->id,
                'created_by' => $admin->id,
                'title' => 'Laporan Produksi ' . $afdeling->name . ' Bulan Lalu',
                'type' => 'produksi',
                'period_year' => Carbon::now()->year,
                'period_month' => Carbon::now()->subMonth()->month,
                'content' => 'Ini adalah detail laporan produksi ' . $afdeling->name . ' bulan lalu. Produksi berjalan lancar dengan pencapaian yang baik.',
                'status' => 'published',
                'is_downloadable' => true,
                'published_at' => Carbon::now()->subDays(2),
            ]);
        }
        
        // Laporan gabungan
        Report::create([
            'afdeling_id' => null,
            'created_by' => $admin->id,
            'title' => 'Laporan Produksi Seluruh Afdeling',
            'type' => 'operasional',
            'period_year' => Carbon::now()->year,
            'period_month' => Carbon::now()->subMonth()->month,
            'content' => 'Ringkasan operasional seluruh afdeling.',
            'status' => 'published',
            'is_downloadable' => true,
            'published_at' => Carbon::now()->subDay(),
        ]);
    }
}
