<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DepartmentReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Collection $departments;

    public function __construct(Collection $departments)
    {
        $this->departments = $departments;
    }

    public function collection()
    {
        return $this->departments;
    }

    public function headings(): array
    {
        return [
            'No',
            'Department Name',
            'Division'

        ];
    }

    public function map($department): array
    {
        static $no = 0;

        return [
            ++$no,

            $department->name,
            $department->division->name ?? '-',

        ];
    }
}
