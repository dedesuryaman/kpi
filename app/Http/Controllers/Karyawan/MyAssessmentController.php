<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Period;
use App\Models\KpiScore;
use Illuminate\Http\Request;

class MyAssessmentController extends Controller
{
    /**
     * List semua periode beserta hasil KPI saya.
     */
    // public function index()
    // {
    //     $employee = Employee::where('user_id', auth()->id())->firstOrFail();

    //     $periods = Period::orderByDesc('start_date')->get();

    //     $assessments = [];

    //     foreach ($periods as $period) {

    //         $scores = KpiScore::where('employee_id', $employee->id)
    //             ->where('period_id', $period->id)
    //             ->get();

    //         $assessments[] = [
    //             'period'      => $period,
    //             'score'       => round($scores->avg('score'), 2),
    //             'final_score' => round($scores->avg('final_score'), 2),
    //             'total_kpi'   => $scores->count(),
    //         ];
    //     }

    //     return view('employee.my-assessment', compact(
    //         'employee',
    //         'assessments'
    //     ));
    // }


    public function index()
    {
        $employee = auth()->user()->employee;

        abort_if(!$employee, 404, 'Employee not found.');


        $periods = Period::latest()->get();

        $assessments = [];

        foreach ($periods as $period) {

            $scores = KpiScore::where('employee_id', $employee->id)
                ->where('period_id', $period->id)
                ->get();

            $assessments[] = [
                'period'      => $period,
                'score'       => round($scores->avg('score'), 2),
                'final_score' => round($scores->avg('final_score'), 2),
                'total_kpi'   => $scores->count(),

            ];
        }

        return view('employees.my-assessment.index', compact('assessments'));
    }

    /**
     * Detail penilaian pada satu periode.
     */
    public function show(Period $period)
    {
        $employee = auth()->user()->employee;

        abort_if(!$employee, 404, 'Employee not found.');

        $scores = KpiScore::with([
            'indicator',
            'indicator.master'
        ])
            ->where('employee_id', $employee->id)
            ->where('period_id', $period->id)
            ->get();

        $averageScore = round($scores->avg('score'), 2);

        $finalScore = round($scores->sum('final_score'), 2);

        return view('employees.my-assessment.show', compact(
            'employee',
            'period',
            'scores',
            'averageScore',
            'finalScore'
        ));
    }
}
