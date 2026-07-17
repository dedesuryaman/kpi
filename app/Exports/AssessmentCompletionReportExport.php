<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Period;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssessmentCompletionReportExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $periodId = $this->request->period_id
            ?? Period::where('status', 'active')->value('id');

        $periodId = $request->period_id
            ?? Period::where('status', 'active')->value('id');

        return Department::select(

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

            ->orderBy('departments.name')->get();
    }

    public function headings(): array
    {
        return [
            'Department',
            'Division',
            'Total Employees',
            'Completed',
            'Not Assessed',
            'Completion (%)'
        ];
    }
}
