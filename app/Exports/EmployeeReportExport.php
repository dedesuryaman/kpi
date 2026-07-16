<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles
{
    protected Collection $employees;

    public function __construct(Collection $employees)
    {
        $this->employees = $employees;
    }

    public function collection()
    {
        return $this->employees;
    }

    public function headings(): array
    {
        return [
            'No',
            'Employee Code',
            'Employee Name',
            'Division',
            'Department',
            'Position',
            'Email',
            'Phone',
            'Status'
        ];
    }

    public function map($employee): array
    {
        static $no = 0;

        return [
            ++$no,
            $employee->employee_code,
            $employee->name,
            $employee->department?->division?->name ?? '-',
            $employee->department?->name ?? '-',
            $employee->position?->name ?? '-',
            $employee->email,
            $employee->phone,
            $employee->employment_status ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            // Header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => '0D6EFD'
                    ]
                ]
            ],

        ];
    }
}
