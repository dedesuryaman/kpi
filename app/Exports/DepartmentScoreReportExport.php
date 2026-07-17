<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartmentScoreReportExport implements FromCollection, WithHeadings
{
    protected Collection $results;

    public function __construct(Collection $results)
    {
        $this->results = $results;
    }

    public function collection()
    {
        return $this->results->map(function ($item) {

            return [
                'Department'      => $item->department_name,
                'Division'        => $item->division_name,



                'Employee'        => $item->total_employee,

                'Average Score'   => round($item->average_score, 2),

                'Highest Score'   => round($item->highest_score, 2),

                'Lowest Score'    => round($item->lowest_score, 2),

            ];
        });
    }

    public function headings(): array
    {
        return [


            'Department',
            'Division',

            'Total Employee',

            'Average Score',

            'Highest Score',

            'Lowest Score',

        ];
    }
}
