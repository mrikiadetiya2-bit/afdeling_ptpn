<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Afdeling;
use App\Models\Harvest;
use App\Models\Target;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class PublicAfdelingController extends Controller
{
    /**
     * Show the interactive map page.
     */
    public function map(): View
    {
        $afdelings = Afdeling::all();
        return view('public.map', compact('afdelings'));
    }

    /**
     * Show the detail page for one afdeling.
     */
    public function show(Afdeling $afdeling): View
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Monthly production for chart (last 6 months)
        $productionChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $label = $date->translatedFormat('M Y');
            $total = Harvest::where('afdeling_id', $afdeling->id)
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('weight_kg');
            $productionChart[] = ['label' => $label, 'value' => (float) $total];
        }

        // Target vs realisasi this year
        $targetChart = [];
        for ($month = 1; $month <= 12; $month++) {
            $target = Target::where('afdeling_id', $afdeling->id)
                ->where('year', $currentYear)
                ->where('month', $month)
                ->value('target_kg') ?? 0;

            $realisasi = Harvest::where('afdeling_id', $afdeling->id)
                ->whereYear('date', $currentYear)
                ->whereMonth('date', $month)
                ->sum('weight_kg');

            $targetChart[] = [
                'label' => Carbon::create($currentYear, $month, 1)->translatedFormat('M'),
                'target' => (float) $target,
                'realisasi' => (float) $realisasi,
            ];
        }

        $thisMonthTarget = Target::where('afdeling_id', $afdeling->id)
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->value('target_kg') ?? 0;

        $thisMonthRealisasi = Harvest::where('afdeling_id', $afdeling->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('weight_kg');

        $percentage = $thisMonthTarget > 0 ? round(($thisMonthRealisasi / $thisMonthTarget) * 100, 1) : 0;

        $afdeling->loadCount(['blocks', 'workers', 'activities', 'harvests']);

        $recentActivities = Activity::where('afdeling_id', $afdeling->id)
            ->with('block')
            ->latest('date')
            ->limit(10)
            ->get();

        $recentHarvests = Harvest::where('afdeling_id', $afdeling->id)
            ->with(['block', 'worker'])
            ->latest('date')
            ->limit(10)
            ->get();

        return view('public.afdeling.show', compact(
            'afdeling',
            'productionChart',
            'targetChart',
            'thisMonthTarget',
            'thisMonthRealisasi',
            'percentage',
            'recentActivities',
            'recentHarvests'
        ));
    }
}
