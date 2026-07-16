<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KpiIndicatorReportExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    ShouldAutoSize
{
    protected Collection $kpiIndicators;

    public function __construct(Collection $kpiIndicators)
    {
        $this->kpiIndicators = $kpiIndicators;
    }

    public function collection()
    {
        return $this->kpiIndicators;
    }

    public function headings(): array
    {
        return [
            'No',
            'KPI Master',
            'Indicator',
            'Description',
            'Weight',
            'Status'
        ];
    }

    public function map($indicator): array
    {
        static $no = 0;

        return [
            ++$no,
            $indicator->kpiMaster->name ?? '-',
            $indicator->name,
            $indicator->description ?? '-',
            $indicator->weight,
            $indicator->status ? 'Active' : 'Inactive',
        ];
    }
}
