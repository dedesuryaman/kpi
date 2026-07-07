<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisionPerformanceController extends Controller
{
    /**
     * Dashboard seluruh divisi
     */
    public function index(Request $request)
    {
        // Periode aktif atau yang dipilih
        $periodId = $request->period_id;

        if (!$periodId) {
            $periodId = Period::where('status', 'active')->value('id');
        }

        $periods = Period::orderByDesc('id')->get();

        $divisions = DB::table('departments')
            ->leftJoin('employees', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('employee_performance_results as epr', function ($join) use ($periodId) {
                $join->on('epr.employee_id', '=', 'employees.id')
                    ->where('epr.period_id', '=', $periodId);
            })
            ->select(
                'departments.id',
                'departments.name',

                DB::raw('COUNT(DISTINCT employees.id) as total_employee'),

                DB::raw('ROUND(AVG(epr.final_score),2) as average_score'),

                DB::raw('ROUND(MAX(epr.final_score),2) as highest_score'),

                DB::raw('ROUND(MIN(epr.final_score),2) as lowest_score')
            )
            ->groupBy(
                'departments.id',
                'departments.name'
            )
            ->orderByDesc('average_score')
            ->get();
        $summary = [

            'total_division' => $divisions->count(),

            'total_employee' => $divisions->sum('total_employee'),

            'average_score' => round(
                $divisions->avg('average_score'),
                2
            ),

            'best_division' => optional(
                $divisions->first()
            )->name,

        ];


        return view(
            'reports.division-performance.index',
            compact(
                'divisions',
                'summary',
                'periods',
                'periodId'
            )
        );
    }

    public function show(Request $request, Department $department)
    {
        $periodId = $request->period_id;

        if (!$periodId) {
            $periodId = Period::where('status', 'active')->value('id');
        }

        /*
    |--------------------------------------------------------------------------
    | Employee Performance
    |--------------------------------------------------------------------------
    */

        // $employees = DB::table('employees')
        //     ->leftJoin('kpi_scores', function ($join) use ($periodId) {

        //         $join->on('employees.id', '=', 'kpi_scores.employee_id')
        //             ->where('kpi_scores.period_id', $periodId);
        //     })
        //     ->where('employees.department_id', $department->id)
        //     ->groupBy(
        //         'employees.id',
        //         'employees.employee_code',
        //         'employees.name'
        //     )
        //     ->select(
        //         'employees.id',
        //         'employees.employee_code',
        //         'employees.name',

        //         DB::raw('AVG(kpi_scores.final_score) as final_score'),
        //         DB::raw('AVG(kpi_scores.score) as average_score'),
        //         DB::raw('COUNT(kpi_scores.id) as total_indicator')
        //     )
        //     ->orderByDesc('final_score')
        //     ->get();

        $employees = DB::table('employees')
            ->leftJoin('employee_performance_results as epr', function ($join) use ($periodId) {
                $join->on('employees.id', '=', 'epr.employee_id')
                    ->where('epr.period_id', '=', $periodId);
            })
            ->where('employees.department_id', $department->id)
            ->select(
                'employees.id',
                'employees.employee_code',
                'employees.name',
                DB::raw('COALESCE(epr.average_score,0) as average_score'),
                DB::raw('COALESCE(epr.final_score,0) as final_score'),
                'epr.grade',
                'epr.rank'
            )
            ->orderByDesc('epr.final_score')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | KPI Indicator (Dynamic)
    |--------------------------------------------------------------------------
    */

        // $indicatorScores = DB::table('kpi_scores')
        //     ->join(
        //         'kpi_masters',
        //         'kpi_scores.indicator_id',
        //         '=',
        //         'kpi_masters.id'
        //     )
        //     ->where('kpi_scores.period_id', $periodId)
        //     ->whereIn('kpi_scores.employee_id', $employees->pluck('id'))
        //     ->select(
        //         'employee_id',
        //         'kpi_masters.name',
        //         'kpi_scores.score',
        //         'kpi_scores.final_score'
        //     )
        //     ->get()
        //     ->groupBy('employee_id');

        /*
    |--------------------------------------------------------------------------
    | Attach Indicator
    |--------------------------------------------------------------------------
    */

        // $employees->transform(function ($employee) use ($indicatorScores) {

        //     $employee->indicators = collect();

        //     if (isset($indicatorScores[$employee->id])) {

        //         foreach ($indicatorScores[$employee->id] as $item) {

        //             $employee->indicators->push([

        //                 'name' => $item->name,

        //                 'score' => $item->score,

        //                 'final_score' => $item->final_score,

        //             ]);
        //         }
        //     }

        //     return $employee;
        // });

        /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

        $statistics = [

            'employee' => $employees->count(),

            'average' => round($employees->avg('final_score'), 2),

            'highest' => round($employees->max('final_score'), 2),

            'lowest' => round($employees->min('final_score'), 2),

        ];

        /*
    |--------------------------------------------------------------------------
    | Top & Bottom
    |--------------------------------------------------------------------------
    */

        $topEmployees = $employees
            ->sortByDesc('final_score')
            ->take(10)
            ->values();

        $bottomEmployees = $employees
            ->sortBy('final_score')
            ->take(10)
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Distribution
    |--------------------------------------------------------------------------
    */

        $distribution = [

            'excellent' => $employees->where('final_score', '>=', 90)->count(),

            'very_good' => $employees->filter(function ($item) {
                return $item->final_score >= 80 && $item->final_score < 90;
            })->count(),

            'good' => $employees->filter(function ($item) {
                return $item->final_score >= 70 && $item->final_score < 80;
            })->count(),

            'fair' => $employees->filter(function ($item) {
                return $item->final_score >= 60 && $item->final_score < 70;
            })->count(),

            'poor' => $employees->where('final_score', '<', 60)->count(),

        ];


        /*
    |--------------------------------------------------------------------------
    | Average KPI per Indicator (Dynamic)
    |--------------------------------------------------------------------------
    */

        // $indicatorAverage = DB::table('kpi_scores')
        //     ->join(
        //         'kpi_masters',
        //         'kpi_scores.indicator_id',
        //         '=',
        //         'kpi_masters.id'
        //     )
        //     ->join(
        //         'employees',
        //         'employees.id',
        //         '=',
        //         'kpi_scores.employee_id'
        //     )
        //     ->where('employees.department_id', $department->id)
        //     ->where('kpi_scores.period_id', $periodId)
        //     ->groupBy(
        //         'kpi_masters.id',
        //         'kpi_masters.name'
        //     )
        //     ->select(
        //         'kpi_masters.name',
        //         DB::raw('AVG(kpi_scores.score) as average')
        //     )
        //     ->orderBy('kpi_masters.id')
        //     ->get();

        $radarData = DB::table('employee_performance_details')
            ->join(
                'employee_performance_results',
                'employee_performance_results.id',
                '=',
                'employee_performance_details.performance_result_id'
            )
            ->join(
                'employees',
                'employees.id',
                '=',
                'employee_performance_results.employee_id'
            )
            ->join(
                'kpi_masters',
                'kpi_masters.id',
                '=',
                'employee_performance_details.kpi_master_id'
            )
            ->where('employee_performance_results.period_id', $periodId)
            ->where('employees.department_id', $department->id)
            ->groupBy(
                'kpi_masters.id',
                'kpi_masters.name'
            )
            ->orderBy('kpi_masters.id')
            ->select(
                'kpi_masters.name',
                DB::raw('ROUND(AVG(employee_performance_details.score),2) as average')
            )
            ->get();

        $radarLabels = $radarData->pluck('name')->all();
        $radarValues = $radarData->pluck('average')->map(fn($v) => (float)$v)->all();


        return view(
            'reports.division-performance.show',
            compact(
                'department',
                'employees',
                'statistics',
                'periodId',
                'topEmployees',
                'bottomEmployees',
                'distribution',
                'radarLabels',
                'radarValues',
            )
        );
    }
}
