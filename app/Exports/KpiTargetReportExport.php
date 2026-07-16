<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KpiTargetReportExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    ShouldAutoSize
{
    protected Collection $targets;

    public function __construct(Collection $targets)
    {
        $this->targets = $targets;
    }

    public function collection()
    {
        return $this->targets;
    }

    public function headings(): array
    {
        return [
            'No',
            'Employee',
            'Department',
            'Position',
            'KPI Master',
            'KPI Indicator',
            'Target',
            'Weight'
        ];
    }

    public function map($target): array
    {
        static $no = 0;

        return [

            ++$no,

            $target->employee->name ?? '-',

            $target->employee->department->name ?? '-',

            $target->employee->position->name ?? '-',

            $target->kpiIndicator->kpiMaster->name ?? '-',

            $target->kpiIndicator->name ?? '-',

            $target->target,

            $target->weight

        ];
    }
}
