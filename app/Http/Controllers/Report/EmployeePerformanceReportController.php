<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeePerformanceResult;
use App\Models\Period;
use App\Models\Position;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\EmployeePerformanceExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeePerformanceReportController extends Controller
{
    public function index()
    {
        $periods = Period::orderByDesc('id')
            ->orderByDesc('name')
            ->get();

        $departments = Department::orderBy('name')
            ->get();

        $positions = Position::orderBy('name')
            ->get();

        return view('reports.employee-performance.index', compact('periods', 'departments', 'positions'));
    }


    public function table(Request $request)
    {
        $results = $this->getResults($request);

        return view(
            'reports.employee-performance.table',
            compact('results')
        );
    }

    public function data(Request $request)
    {
        $query = Employee::query()
            ->with([
                'department',
                'position',
            ]);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $employees = $query->get();

        return view(
            'reports.employee-performance.table',
            compact('employees')
        );
    }

    public function print(Request $request)
    {
        $results = $this->getResults($request);

        $period = null;

        if ($request->filled('period_id')) {
            $period = Period::find($request->period_id);
        }

        return view(
            'reports.employee-performance.print',
            compact(
                'results',
                'period'
            )
        );
    }

    public function pdf(Request $request)
    {
        $results = $this->getResults($request);

        $period = null;

        if ($request->filled('period_id')) {
            $period = Period::find($request->period_id);
        }

        $pdf = Pdf::loadView(
            'reports.employee-performance.pdf',
            compact(
                'results',
                'period'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('employee-performance-report.pdf');

        // atau download
        // return $pdf->download('employee-performance-report.pdf');
    }

    public function excel(Request $request)
    {
        return Excel::download(
            new EmployeePerformanceExport($request),
            'employee-performance-report.xlsx'
        );
    }
    private function getResults(Request $request)
    {
        $query = EmployeePerformanceResult::with([
            'period',
            'employee.department',
            'employee.position',
        ]);

        if ($request->filled('period_id')) {
            $query->where('period_id', $request->period_id);
        }

        if ($request->filled('department_id')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }

        if ($request->filled('position_id')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('position_id', $request->position_id);
            });
        }

        if ($request->filled('employment_status')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('employment_status', $request->employment_status);
            });
        }

        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->whereHas('employee', function ($q) use ($keyword) {

                $q->where('employee_code', 'like', "%{$keyword}%")
                    ->orWhere('name', 'like', "%{$keyword}%");
            });
        }

        return $query
            ->orderBy('rank')
            ->get();
    }
}
