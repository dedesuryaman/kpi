<?php

namespace App\Exports;

use App\Models\EmployeePerformanceResult;
use App\Models\Period;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeScoreReportExport implements FromCollection, WithHeadings
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $periodId = $this->request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $this->request->department_id;
        $employee = $this->request->employee;

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

        return $query
            ->orderByDesc('final_score')
            ->get()
            ->map(function ($item) {

                return [

                    'Employee' => $item->employee->name,

                    'Department' => $item->employee->department->name ?? '-',

                    'Position' => $item->employee->position->name ?? '-',

                    'Average Score' => round($item->average_score, 2),

                    'Grade' => $item->grade,

                    'Rank' => $item->rank,

                    'Final Score' => round($item->final_score, 2),

                ];
            });
    }

    public function headings(): array
    {
        return [

            'Employee',

            'Department',

            'Position',

            'Average Score',

            'Grade',

            'Rank',

            'Final Score'

        ];
    }
}
