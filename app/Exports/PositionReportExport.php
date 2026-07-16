<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PositionReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected Collection $positions;

    public function __construct(Collection $positions)
    {
        $this->positions = $positions;
    }

    public function collection()
    {
        return $this->positions;
    }

    public function headings(): array
    {
        return [
            'No',

            'Position Name',
            'Department',
            'Total Employee'
        ];
    }

    public function map($position): array
    {
        static $no = 0;

        return [
            ++$no,

            $position->name,
            $position->department->name ?? '-',
            $position->employees->count() ? 'Active' : 'Inactive',
        ];
    }
}
