<?php

namespace App\Http\Controllers\Reports;

use App\Exports\AssessmentCompletionReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Department;
use App\Models\EmployeePerformanceResult;
use App\Models\KpiScore;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssessmentReportExport;
use App\Exports\DepartmentScoreReportExport;
use App\Exports\EmployeeScoreReportExport;
use Illuminate\Support\Facades\DB;

class AssessmentReportController extends Controller
{
    /**
     * Assessment Summary
     */
    public function summary(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.assessment.summary', $data);
    }

    public function assessmentExcel(Request $request)
    {
        return Excel::download(
            new AssessmentReportExport($request),
            'assessment-report.xlsx'
        );
    }

    public function assessmentPdf(Request $request)
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;

        $query = EmployeePerformanceResult::with([
            'employee.department'
        ])
            ->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }
        $results = $query->get();

        $pdf = Pdf::loadView(
            'reports.assessment.pdf.assessments',
            compact('results')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('assessment-report.pdf');
    }


    /**
     * Employee KPI Scores
     */
    public function employeeScores(Request $request)
    {
        $data = $this->getData($request);


        return view('reports.assessment.employee-scores', $data);
    }

    public function employeeScoresExcel(Request $request)
    {
        return Excel::download(
            new EmployeeScoreReportExport($request),
            'employee-score-report.xlsx'
        );
    }

    public function employeeScoresPdf(Request $request)
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;
        $employee = $request->employee;

        $query = EmployeePerformanceResult::with([
            'employee.department',
            'employee.position'
        ])->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        if ($employee) {
            $query->whereHas('employee', function ($q) use ($employee) {
                $q->where('name', 'like', "%{$employee}%");
            });
        }

        $results = $query
            ->orderByDesc('final_score')
            ->get();

        $pdf = Pdf::loadView(
            'reports.assessment.pdf.employee-scores',
            compact('results')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('employee-score-report.pdf');
    }


    /**
     * Department KPI Scores
     */
    public function departmentScores(Request $request)
    {
        $results = $this->getDepartmentScores($request)->paginate(15);

        return view('reports.assessment.department-scores', [
            'results' => $results,
            'periods' => Period::all(),
            'selectedPeriod' => $request->period_id
                ?? Period::where('status', 'active')->value('id'),
        ]);
    }
    public function departmentScoresExcel(Request $request)
    {
        return Excel::download(
            new DepartmentScoreReportExport(
                $this->getDepartmentScores($request)->get()
            ),
            'department-score-report.xlsx'
        );
    }
    public function departmentScoresPdf(Request $request)
    {
        $results = $this->getDepartmentScores($request)->get();

        $pdf = Pdf::loadView(
            'reports.assessment.pdf.department-scores',
            compact('results')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('department-score-report.pdf');
    }
    private function getDepartmentScores(Request $request)
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        return Department::select(
            'departments.id',
            'departments.name as department_name',
            'divisions.name as division_name',
            DB::raw('COUNT(DISTINCT employees.id) as total_employee'),
            DB::raw('COALESCE(AVG(employee_performance_results.final_score),0) as average_score'),
            DB::raw('COALESCE(MAX(employee_performance_results.final_score),0) as highest_score'),
            DB::raw('COALESCE(MIN(employee_performance_results.final_score),0) as lowest_score')
        )
            ->leftJoin('divisions', 'divisions.id', '=', 'departments.division_id')
            ->leftJoin('employees', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('employee_performance_results', function ($join) use ($periodId) {
                $join->on('employee_performance_results.employee_id', '=', 'employees.id')
                    ->where('employee_performance_results.period_id', $periodId);
            })
            ->groupBy(
                'departments.id',
                'departments.name',
                'divisions.name'
            )
            ->orderBy('department_name');
    }


    /**
     * KPI Completion Status
     */
    public function completion(Request $request)
    {
        $results = $this->getCompletionStatus($request)->paginate(15);

        return view('reports.assessment.completion', [
            'results' => $results,
            'periods' => Period::all(),
            'selectedPeriod' => $request->period_id
                ?? Period::where('status', 'active')->value('id'),
        ]);
    }

    public function assessmentCompletionExcel(Request $request)
    {
        return Excel::download(
            new AssessmentCompletionReportExport($request),
            'assessment_completion_report.xlsx'
        );
    }

    public function assessmentCompletionPdf(Request $request)
    {
        $results = $this->getCompletionStatus($request)->get();

        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $period = Period::find($periodId);

        $pdf = Pdf::loadView(
            'reports.assessment.pdf.completion',
            compact('results', 'period')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('assessment_completion_report.pdf');
    }

    private function getCompletionStatus(Request $request)
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        return Department::select(
            'departments.id',
            'departments.name as department_name',
            'divisions.name as division_name',

            DB::raw('COUNT(DISTINCT employees.id) AS total_employee'),

            DB::raw('COUNT(DISTINCT employee_performance_results.employee_id) AS assessed_employee'),

            DB::raw('
            COUNT(DISTINCT employees.id)
            - COUNT(DISTINCT employee_performance_results.employee_id)
            AS not_assessed_employee
        '),

            DB::raw('
            CASE
                WHEN COUNT(DISTINCT employees.id) = 0 THEN 0
                ELSE ROUND(
                    COUNT(DISTINCT employee_performance_results.employee_id)
                    * 100.0 /
                    COUNT(DISTINCT employees.id),
                    2
                )
            END AS completion_percentage
        ')
        )
            ->leftJoin('divisions', 'divisions.id', '=', 'departments.division_id')

            ->leftJoin('employees', 'employees.department_id', '=', 'departments.id')

            ->leftJoin('employee_performance_results', function ($join) use ($periodId) {

                $join->on(
                    'employee_performance_results.employee_id',
                    '=',
                    'employees.id'
                )->where(
                    'employee_performance_results.period_id',
                    '=',
                    $periodId
                );
            })

            ->groupBy(
                'departments.id',
                'departments.name',
                'divisions.name'
            )

            ->orderBy('departments.name');
    }

    /**
     * Monthly Report
     */
    public function monthly(Request $request)
    {
        $selectedYear = $request->year ?? now()->year;
        $selectedDepartment = $request->department_id;

        $query = EmployeePerformanceResult::query()
            ->join('periods', 'employee_performance_results.period_id', '=', 'periods.id')
            ->join('employees', 'employee_performance_results.employee_id', '=', 'employees.id')
            ->whereYear('periods.start_date', $selectedYear);

        if ($selectedDepartment) {
            $query->where('employees.department_id', $selectedDepartment);
        }

        $results = $query
            ->groupBy('periods.id', 'periods.name')
            ->selectRaw('
            periods.name as period_name,
            COUNT(*) as employee_count,
            AVG(final_score) as average_score,
            MAX(final_score) as highest_score,
            MIN(final_score) as lowest_score
        ')
            ->orderBy('periods.start_date')
            ->get();

        return view('reports.assessment.monthly', [

            'results' => $results,

            'departments' => Department::orderBy('name')->get(),

            'years' => Period::selectRaw('YEAR(start_date) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year'),

            'selectedYear' => $selectedYear,

            'selectedDepartment' => $selectedDepartment,

        ]);
    }
    /**
     * Annual Report
     */
    public function annual(Request $request)
    {
        $selectedYear = $request->year;
        $selectedDepartment = $request->department_id;

        $query = EmployeePerformanceResult::query()
            ->join('periods', 'employee_performance_results.period_id', '=', 'periods.id')
            ->join('employees', 'employee_performance_results.employee_id', '=', 'employees.id');

        if ($selectedYear) {
            $query->whereYear('periods.start_date', $selectedYear);
        }

        if ($selectedDepartment) {
            $query->where('employees.department_id', $selectedDepartment);
        }

        $results = $query
            ->groupByRaw('YEAR(periods.start_date)')
            ->selectRaw('
            YEAR(periods.start_date) as year,
            COUNT(*) as employee_count,
            AVG(final_score) as average_score,
            MAX(final_score) as highest_score,
            MIN(final_score) as lowest_score
        ')
            ->orderBy('year')
            ->get();

        return view('reports.assessment.annual', [

            'results' => $results,

            'departments' => Department::orderBy('name')->get(),

            'years' => Period::selectRaw('YEAR(start_date) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year'),

            'selectedYear' => $selectedYear,

            'selectedDepartment' => $selectedDepartment,

        ]);
    }

    /**
     * Common Query
     */
    private function getData(Request $request): array
    {
        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $request->department_id;

        $query = EmployeePerformanceResult::with([
            'employee.department'
        ])
            ->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        return [
            'results' => $query->paginate(20),

            'periods' => Period::latest()->get(),

            'departments' => Department::orderBy('name')->get(),

            'selectedPeriod' => $periodId,

            'selectedDepartment' => $departmentId,
        ];
    }
}
