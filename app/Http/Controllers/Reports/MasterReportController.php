<?php

namespace App\Http\Controllers\Reports;

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

class MasterReportController extends Controller
{
    /**
     * Employee Report
     */
    public function employees(Request $request)
    {
        $employees = Employee::with([
            'department',
            'department.division',
            'position'
        ])
            ->orderBy('employee_code')
            ->paginate(20);

        return view('reports.master.employees', compact('employees'));
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

    /**
     * KPI Target Report
     */
    public function kpiTargets(Request $request)
    {
        $targets = KpiTarget::with([
            'employee',
            'kpiIndicator',
            'period'
        ])
            ->paginate(20);

        return view('reports.master.kpi-targets', compact('targets'));
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
}
