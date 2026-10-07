<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Afdeling;
use App\Models\Harvest;
use App\Models\Activity;
use App\Models\Report;
use Illuminate\View\View;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show the public home page.
     */
    public function index(): View
    {
        $afdelings = Afdeling::withCount(['blocks', 'workers', 'activities'])->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalProductionThisMonth = Harvest::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('weight_kg');

        $totalActivitiesThisMonth = Activity::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();

        $recentReports = Report::where('status', 'published')
            ->with('afdeling')
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('public.home', compact(
            'afdelings',
            'totalProductionThisMonth',
            'totalActivitiesThisMonth',
            'recentReports'
        ));
    }

    /**
     * Show the about page.
     */
    public function about(): View
    {
        return view('public.about');
    }
}
