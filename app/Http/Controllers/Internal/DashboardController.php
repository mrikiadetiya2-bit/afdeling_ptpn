<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use App\Models\Afdeling;
use App\Models\Harvest;
use App\Models\Target;
use App\Models\Activity;
use App\Models\Worker;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the internal dashboard.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $currentYear = $request->input('year', Carbon::now()->year);
        $currentMonth = $request->input('month', Carbon::now()->month);

        $afdelings = Afdeling::all();

        // Per-afdeling summary for comparison
        $afdelingStats = [];
        foreach ($afdelings as $afdeling) {
            if ($user->role === 'mandor' && $user->afdeling_id !== $afdeling->id) {
                continue;
            }

            $target = Target::where('afdeling_id', $afdeling->id)
                ->where('year', $currentYear)
                ->where('month', $currentMonth)
                ->value('target_kg') ?? 0;

            $realisasi = Harvest::where('afdeling_id', $afdeling->id)
                ->whereYear('date', $currentYear)
                ->whereMonth('date', $currentMonth)
                ->sum('weight_kg');

            $percentage = $target > 0 ? round(($realisasi / $target) * 100, 1) : 0;

            $afdelingStats[] = [
                'afdeling' => $afdeling,
                'target' => $target,
                'realisasi' => $realisasi,
                'percentage' => $percentage,
                'selisih' => $realisasi - $target,
            ];
        }

        // Today's stats
        $todayHarvest = Harvest::whereDate('date', Carbon::today())->sum('weight_kg');
        $todayActivities = Activity::whereDate('date', Carbon::today())->count();

        $totalProductionThisMonth = Harvest::whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('weight_kg');

        $totalTargetThisMonth = Target::where('year', $currentYear)
            ->where('month', $currentMonth)
            ->sum('target_kg');

        $overallPercentage = $totalTargetThisMonth > 0
            ? round(($totalProductionThisMonth / $totalTargetThisMonth) * 100, 1)
            : 0;

        // Chart: last 6 months production per afdeling
        $chartLabels = [];
        $chartDatasets = [];
        $colors = ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444'];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $chartLabels[] = $date->translatedFormat('M Y');
        }

        foreach ($afdelings as $idx => $afdeling) {
            $data = [];
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $total = Harvest::where('afdeling_id', $afdeling->id)
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month)
                    ->sum('weight_kg');
                $data[] = (float) $total;
            }
            $chartDatasets[] = [
                'label' => $afdeling->name,
                'data' => $data,
                'color' => $colors[$idx % count($colors)],
            ];
        }

        $recentReports = Report::with('afdeling')
            ->latest()
            ->limit(5)
            ->get();

        $totalWorkers = Worker::count();

        return view('internal.dashboard', compact(
            'afdelingStats',
            'todayHarvest',
            'todayActivities',
            'totalProductionThisMonth',
            'totalTargetThisMonth',
            'overallPercentage',
            'chartLabels',
            'chartDatasets',
            'recentReports',
            'totalWorkers',
            'currentYear',
            'currentMonth',
            'afdelings'
        ));
    }
}
