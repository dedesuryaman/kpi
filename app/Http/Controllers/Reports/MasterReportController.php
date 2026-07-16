<?php

namespace App\Http\Controllers\Reports;

use App\Exports\DepartmentReportExport;
use App\Exports\DivisionReportExport;
use App\Exports\EmployeeReportExport;
use App\Exports\KpiIndicatorReportExport;
use App\Exports\KpiMasterReportExport;
use App\Exports\PositionReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Division;
use App\Models\Position;
use App\Models\Period;
use App\Models\KpiMaster;
use App\Models\KpiIndicator;
use App\Models\KpiTarget;
use Barryvdh\DomPDF\Facade\Pdf;

use Maatwebsite\Excel\Facades\Excel;

class MasterReportController extends Controller
{
    /**
     * Employee Report
     */
    public function employees(Request $request)
    {
        $departments = Department::orderBy('name')->get();
        $positions   = Position::orderBy('name')->get();

        $query = Employee::with([
            'department',
            'department.division',
            'position'
        ]);

        // Filter Department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filter Position
        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        // Search Employee
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $employees = $query
            ->orderBy('employee_code')
            ->paginate(20)
            ->withQueryString();

        return view('reports.master.employees', compact(
            'employees',
            'departments',
            'positions'
        ));
    }

    /**
     * Department Report
     */
    public function departments(Request $request)
    {
        $departments = Department::orderBy('name')
            ->paginate(20);

        return view('reports.master.departments', compact('departments'));
    }

    /**
     * Division Report
     */
    public function divisions(Request $request)
    {
        $divisions = Division::orderBy('name')
            ->paginate(20);

        return view('reports.master.divisions', compact('divisions'));
    }

    /**
     * Position Report
     */
    public function positions(Request $request)
    {
        $positions = Position::orderBy('name')
            ->paginate(20);

        return view('reports.master.positions', compact('positions'));
    }

    private function positionQuery(Request $request)
    {
        return Position::with('department')
            ->orderBy('name');
    }

    public function positionsExcel(Request $request)
    {
        return Excel::download(
            new PositionReportExport(
                $this->positionQuery($request)->get()
            ),
            'Position_Report.xlsx'
        );
    }

    public function positionsPdf(Request $request)
    {
        $positions = $this->positionQuery($request)->get();

        $pdf = Pdf::loadView(
            'reports.master.pdf.position-report',
            compact('positions')
        );

        return $pdf->stream('Position_Report.pdf');
    }


    /**
     * KPI Master Report
     */
    public function kpiMaster(Request $request)
    {
        $masters = KpiMaster::with('indicators')
            ->orderBy('name')
            ->paginate(20);

        return view('reports.master.kpi-master', compact('masters'));
    }

    private function kpiMasterQuery(Request $request)
    {
        return KpiMaster::query()
            ->orderBy('name');
    }

    public function kpiMasterExcel(Request $request)
    {
        return Excel::download(
            new KpiMasterReportExport(
                $this->kpiMasterQuery($request)->get()
            ),
            'KPI_Master_Report.xlsx'
        );
    }

    public function kpiMasterPdf(Request $request)
    {
        $kpiMasters = $this->kpiMasterQuery($request)->get();

        $pdf = Pdf::loadView(
            'reports.master.pdf.kpi-master-report',
            compact('kpiMasters')
        );

        return $pdf->stream('KPI_Master_Report.pdf');
    }

    /**
     * KPI Indicator Report
     */
    public function kpiIndicators(Request $request)
    {
        $indicators = KpiIndicator::with('kpiMaster')
            ->orderBy('kpi_master_id')
            ->paginate(20);

        return view('reports.master.kpi-indicators', compact('indicators'));
    }

    private function kpiIndicatorQuery(Request $request)
    {
        return KpiIndicator::with('kpiMaster')
            ->orderBy('kpi_master_id')
            ->orderBy('name');
    }

    public function kpiIndicatorsExcel(Request $request)
    {
        return Excel::download(
            new KpiIndicatorReportExport(
                $this->kpiIndicatorQuery($request)->get()
            ),
            'KPI_Indicator_Report.xlsx'
        );
    }


    public function kpiIndicatorsPdf(Request $request)
    {
        $kpiIndicators = $this->kpiIndicatorQuery($request)->get();

        $pdf = Pdf::loadView(
            'reports.master.pdf.kpi-indicator-report',
            compact('kpiIndicators')
        );

        return $pdf->stream('KPI_Indicator_Report.pdf');
    }
    /**
     * KPI Target Report
     */
    public function kpiTargets(Request $request)
    {
        $periods = Period::orderBy('start_date', 'desc')->get();

        $query = KpiTarget::with([
            'employee',
            'kpiIndicator.kpiMaster',
            'period'
        ]);

        // Search Employee
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('employee_code', 'like', "%{$search}%");
            });
        }

        // Filter Period
        if ($request->filled('period_id')) {
            $query->where('period_id', $request->period_id);
        }

        $targets = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('reports.master.kpi-targets', compact(
            'targets',
            'periods'
        ));
    }

    private function kpiTargetQuery(Request $request)
    {
        return KpiTarget::with([
            'employee.department',
            'employee.position',
            'kpiIndicator.kpiMaster'
        ])
            ->orderBy('employee_id');
    }
    public function kpiTargetsExcel(Request $request)
    {
        return Excel::download(
            new KpiTargetReportExport(
                $this->kpiTargetQuery($request)->get()
            ),
            'KPI_Target_Report.xlsx'
        );
    }
    public function kpiTargetsPdf(Request $request)
    {
        $kpiTargets = $this->kpiTargetQuery($request)->get();

        $pdf = Pdf::loadView(
            'reports.master.pdf.kpi-target-report',
            compact('kpiTargets')
        );

        return $pdf->stream('KPI_Target_Report.pdf');
    }
    /**
     * Period Report
     */
    public function periods(Request $request)
    {
        $periods = Period::latest()
            ->paginate(20);

        return view('reports.master.periods', compact('periods'));
    }


    private function employeeQuery(Request $request)
    {
        $query = Employee::with([
            'department',
            'department.division',
            'position'
        ]);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('employee_code');
    }

    public function employeesExcel(Request $request)
    {
        return Excel::download(
            new EmployeeReportExport($this->employeeQuery($request)->get()),
            'employee-report.xlsx'
        );
    }

    public function employeesPdf(Request $request)
    {
        $employees = $this->employeeQuery($request)->get();

        $pdf = Pdf::loadView(
            'reports.master.pdf.employee-report',
            compact('employees')
        );

        return $pdf->stream('employee-report.pdf');
    }

    public function departmentsExcel()
    {
        return Excel::download(
            new DepartmentReportExport(
                Department::with('division')
                    ->orderBy('name')
                    ->get()
            ),
            'Department_Report.xlsx'
        );
    }

    public function departmentsPdf()
    {
        $departments = Department::with('division')
            ->orderBy('name')
            ->get();

        $pdf = Pdf::loadView(
            'reports.master.pdf.department-report',
            compact('departments')
        );

        return $pdf->stream('Department_Report.pdf');
    }

    private function divisionQuery(Request $request)
    {
        return Division::orderBy('name');
    }

    public function divisionsExcel(Request $request)
    {
        return Excel::download(
            new DivisionReportExport(
                $this->divisionQuery($request)->get()
            ),
            'Division_Report.xlsx'
        );
    }

    public function divisionsPdf(Request $request)
    {
        $divisions = $this->divisionQuery($request)->get();

        $pdf = Pdf::loadView(
            'reports.master.pdf.division-report',
            compact('divisions')
        );

        return $pdf->stream('Division_Report.pdf');
    }
}
