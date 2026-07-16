<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KpiMasterReportExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected Collection $kpiMasters;

    public function __construct(Collection $kpiMasters)
    {
        $this->kpiMasters = $kpiMasters;
    }

    public function collection()
    {
        return $this->kpiMasters;
    }

    public function headings(): array
    {
        return [
            'No',
            'KPI Master',
            'Description',
            'Indicators',
            'Status'
        ];
    }

    public function map($kpi): array
    {
        static $no = 0;

        return [
            ++$no,
            $kpi->name,
            $kpi->description ?: '-',
            $kpi->indicators->count(),
            $kpi->status ? 'Active' : 'Inactive',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            // Header tabel
            5 => [

                'font' => [
                    // 'bold' => true,
                    //'color' => [
                    //    'rgb' => 'FFFFFF'
                    // ]
                ],

                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    //'startColor' => [
                    //    'rgb' => '0D6EFD'
                    //]
                ],

                'alignment' => [
                    //'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ]

            ]

        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                // Sisipkan 4 baris
                $sheet->insertNewRowBefore(1, 4);

                // Company
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue(
                    'A1',
                    'PT. MAKERINDO PRIMA SOLUSI'
                );

                // Report Title
                $sheet->mergeCells('A2:E2');
                $sheet->setCellValue(
                    'A2',
                    'KPI MASTER REPORT'
                );

                // Date
                $sheet->mergeCells('A3:E3');
                $sheet->setCellValue(
                    'A3',
                    'Generated : ' . now()->format('d F Y H:i')
                );

                // Summary
                $sheet->mergeCells('A4:E4');
                $sheet->setCellValue(
                    'A4',
                    'Total KPI Master : ' . $this->kpiMasters->count()
                );

                // Style Company
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'size' => 18,
                        'bold' => true,
                        'color' => [
                            'rgb' => '04475C'
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // Style Title
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'size' => 14,
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // Date & Summary
                $sheet->getStyle('A3:A4')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $lastRow = $sheet->getHighestRow();
                // Header Table
                $sheet->getStyle('A5:E5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'color' => [
                            'rgb' => 'FFFFFF'
                        ]
                    ],

                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '04475C'
                        ]
                    ],

                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER
                    ]
                ]);

                $sheet->getStyle("A6:E{$lastRow}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle("A6:A{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("D6:E{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Border
                $sheet->getStyle("A5:E{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Freeze Header
                $sheet->freezePane('A6');

                // Auto Filter
                $sheet->setAutoFilter("A5:E{$lastRow}");

                // Font
                $sheet->getStyle("A1:E{$lastRow}")
                    ->getFont()
                    ->setName('Calibri');
            }

        ];
    }
}
