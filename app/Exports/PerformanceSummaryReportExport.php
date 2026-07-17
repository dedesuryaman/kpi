<?php

namespace App\Exports;

use App\Models\Department;
use App\Models\EmployeePerformanceResult;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Period;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PerformanceSummaryReportExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $periodId = $this->request->period_id
            ?? Period::where('status', 'active')->value('id');

        $departmentId = $this->request->department_id;

        $query = EmployeePerformanceResult::with([
            'employee.department',
            'employee.position',
            'abcResult',
            'mdpResult',
            'latestAiAnalysis',
            'latestRewardRecommendation'
        ])->where('period_id', $periodId);

        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        return $query
            ->orderByDesc('final_score')
            ->get()
            ->map(function ($item) {

                return [

                    'Employee'       => $item->employee->name ?? '-',

                    'Department'     => $item->employee->department->name ?? '-',

                    'Final Score'    => round($item->final_score, 2),

                    'ABC Fitness'    => $item->abcResult->fitness ?? '-',

                    'MDP State'      => $item->mdpResult->state->name ?? '-',

                    'Recommendation' => optional($item->latestAiAnalysis)->recommendation ?? '-',

                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Department',
            'Final Score',
            'ABC Fitness',
            'MDP State',
            'Ai Recommendation'
        ];
    }
}
