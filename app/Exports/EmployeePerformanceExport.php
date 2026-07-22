<?php

namespace App\Exports;

use App\Models\EmployeePerformanceResult;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeePerformanceExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles
{
    protected Request $request;

    protected int $no = 1;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = EmployeePerformanceResult::with([
            'employee.department',
            'employee.position',
        ]);

        // Period
        if ($this->request->filled('period_id')) {
            $query->where('period_id', $this->request->period_id);
        }

        // Department
        if ($this->request->filled('department_id')) {
            $query->whereHas('employee', function ($q) {
                $q->where('department_id', $this->request->department_id);
            });
        }

        // Position
        if ($this->request->filled('position_id')) {
            $query->whereHas('employee', function ($q) {
                $q->where('position_id', $this->request->position_id);
            });
        }

        // Employment Status
        if ($this->request->filled('employment_status')) {
            $query->whereHas('employee', function ($q) {
                $q->where(
                    'employment_status',
                    $this->request->employment_status
                );
            });
        }

        // Keyword
        if ($this->request->filled('keyword')) {

            $keyword = $this->request->keyword;

            $query->whereHas('employee', function ($q) use ($keyword) {

                $q->where('employee_code', 'like', "%{$keyword}%")
                    ->orWhere('name', 'like', "%{$keyword}%");
            });
        }

        return $query
            ->orderBy('rank')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Rank',
            'No',
            'Employee Code',
            'Employee Name',
            'Department',
            'Position',
            'Average Score',
            'Final Score',
            'Grade',
        ];
    }

    public function map($result): array
    {
        return [
            $result->rank,
            $this->no++,
            $result->employee->employee_code ?? '-',
            $result->employee->name,
            $result->employee->department?->name ?? '-',
            $result->employee->position?->name ?? '-',
            $result->average_score,
            $result->final_score,
            $result->grade,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            // Header
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],

        ];
    }
}
