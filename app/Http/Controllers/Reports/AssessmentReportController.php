<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Department;
use App\Models\EmployeePerformanceResult;
use App\Models\KpiScore;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssessmentReportExport;

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

    /**
     * Department KPI Scores
     */
    public function departmentScores(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.assessment.department-scores', $data);
    }

    /**
     * KPI Completion Status
     */
    public function completion(Request $request)
    {
        $data = $this->getData($request);

        return view('reports.assessment.completion', $data);
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
