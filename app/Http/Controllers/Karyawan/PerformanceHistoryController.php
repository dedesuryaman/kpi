<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\KpiScore;
use App\Models\Period;
use Illuminate\Http\Request;

class PerformanceHistoryController extends Controller
{

    public function index(Request $request)
    {
        $employee = auth()->user()->employee;

        abort_if(!$employee, 404, 'Employee not found.');

        $year = $request->year;

        /*
    |--------------------------------------------------------------------------
    | Years Filter
    |--------------------------------------------------------------------------
    */

        $years = Period::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        /*
    |--------------------------------------------------------------------------
    | KPI Scores
    |--------------------------------------------------------------------------
    */

        $query = KpiScore::with([
            'period',
            'indicator.master'
        ])
            ->where('employee_id', $employee->id);

        if ($year) {
            $query->whereHas('period', function ($q) use ($year) {
                $q->whereYear('start_date', $year);
            });
        }

        $scores = $query
            ->orderBy('period_id')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Performance History
    |--------------------------------------------------------------------------
    */

        $histories = $scores
            ->groupBy('period_id')
            ->map(function ($items) {

                $finalScore = round($items->sum('final_score'), 2);

                return [
                    'period'          => $items->first()->period,
                    'total_kpi'       => $items->count(),
                    'average_score'   => round($items->avg('score'), 2),
                    'final_score'     => $finalScore,
                    'rating'          => $this->rating($finalScore),
                ];
            })
            ->sortBy(fn($item) => $item['period']->start_date)
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

        $current = $histories->last();

        $highest = $histories->max('final_score') ?? 0;

        $lowest = $histories->min('final_score') ?? 0;

        $average = round($histories->avg('final_score') ?? 0, 2);

        $previous = $histories->count() >= 2
            ? $histories[$histories->count() - 2]['final_score']
            : 0;

        $growth = round(($current['final_score'] ?? 0) - $previous, 2);

        /*
    |--------------------------------------------------------------------------
    | Trend Chart
    |--------------------------------------------------------------------------
    */

        $trendLabels = $histories
            ->pluck('period.name')
            ->values();

        $trendScores = $histories
            ->pluck('final_score')
            ->values();

        /*
    |--------------------------------------------------------------------------
    | KPI Category
    |--------------------------------------------------------------------------
    */

        $categories = $scores
            ->groupBy('kpi_master_id')
            ->map(function ($items) {

                return [
                    'name'  => $items->first()->indicator->master->name,
                    'score' => round($items->avg('final_score'), 2),
                ];
            })
            ->sortByDesc('score')
            ->values();

        $categoryLabels = $categories->pluck('name');

        $categoryScores = $categories->pluck('score');

        /*
    |--------------------------------------------------------------------------
    | Best & Worst KPI
    |--------------------------------------------------------------------------
    */

        $bestKPIs = $categories
            ->sortByDesc('score')
            ->take(5)
            ->values();

        $worstKPIs = $categories
            ->sortBy('score')
            ->take(5)
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Rating Distribution
    |--------------------------------------------------------------------------
    */

        $ratingDistribution = [
            'Excellent' => 0,
            'Very Good' => 0,
            'Good' => 0,
            'Fair' => 0,
            'Poor' => 0,
        ];

        foreach ($histories as $history) {
            $ratingDistribution[$history['rating']]++;
        }

        return view('employees.performance-history.index', compact(
            'employee',
            'years',
            'year',

            'histories',

            'current',
            'highest',
            'lowest',
            'average',
            'growth',

            'trendLabels',
            'trendScores',

            'categoryLabels',
            'categoryScores',

            'bestKPIs',
            'worstKPIs',

            'ratingDistribution'
        ));
    }

    private function rating($score)
    {
        return match (true) {
            $score >= 90 => 'Excellent',
            $score >= 80 => 'Very Good',
            $score >= 70 => 'Good',
            $score >= 60 => 'Fair',
            default => 'Poor',
        };
    }
}
