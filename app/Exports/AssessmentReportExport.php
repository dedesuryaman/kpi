<?php

namespace App\Exports;

use App\Models\KpiScore;
use App\Models\Period;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssessmentReportExport implements FromCollection, WithHeadings
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

        $query = KpiScore::with([
            'employee.department',
            'kpiIndicator.kpiMaster',
            'period',
            'assessor'
        ]);

        // Filter periode
        if ($periodId) {
            $query->where('period_id', $periodId);
        }

        // Filter department
        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        // Filter employee (opsional)
        if ($this->request->filled('employee_id')) {
            $query->where('employee_id', $this->request->employee_id);
        }

        return $query->get()->map(function ($item) {

            return [
                'Employee'        => $item->employee->name ?? '-',
                'Department'      => $item->employee->department->name ?? '-',
                'KPI Master'      => $item->kpiIndicator->kpiMaster->name ?? '-',
                'Indicator'       => $item->kpiIndicator->name ?? '-',
                'Score'           => $item->score,
                'Final Score'     => $item->final_score,
                'Period'          => $item->period->name ?? '-',
                'Assessor'        => $item->assessor->name ?? '-',
                'Assessment Date' => optional($item->assessment_date)?->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Department',
            'KPI Master',
            'Indicator',
            'Score',
            'Final Score',
            'Period',
            'Assessor',
            'Assessment Date',
        ];
    }
}
