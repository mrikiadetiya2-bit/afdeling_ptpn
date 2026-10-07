<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Afdeling;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicReportController extends Controller
{
    /**
     * Show all published reports.
     */
    public function index(Request $request): View
    {
        $query = Report::where('status', 'published')->with('afdeling', 'author');

        if ($request->filled('afdeling_id')) {
            $query->where('afdeling_id', $request->afdeling_id);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('year')) {
            $query->where('period_year', $request->year);
        }
        if ($request->filled('month')) {
            $query->where('period_month', $request->month);
        }

        $reports = $query->latest('published_at')->paginate(12)->withQueryString();
        $afdelings = Afdeling::all();

        return view('public.reports.index', compact('reports', 'afdelings'));
    }

    /**
     * Show a single published report.
     */
    public function show(Report $report): View
    {
        abort_if($report->status !== 'published', 404);
        $report->load('afdeling', 'author');
        return view('public.reports.show', compact('report'));
    }
}
