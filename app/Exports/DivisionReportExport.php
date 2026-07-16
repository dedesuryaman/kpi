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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DivisionReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected Collection $divisions;

    public function __construct(Collection $divisions)
    {
        $this->divisions = $divisions;
    }

    public function collection()
    {
        return $this->divisions;
    }

    public function headings(): array
    {
        return [
            'No',
            'Division Name',
            'Description',
            'Total Employee',
        ];
    }

    public function map($division): array
    {
        static $no = 0;

        return [
            ++$no,
            $division->name,
            $division->description ?? '-',
            $division->employees->count(),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            // Header tabel (baris 5)
            5 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],

                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '0D6EFD'
                    ]
                ],

                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ]

            ]

        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                // Sisipkan 4 baris di atas
                $sheet->insertNewRowBefore(1, 4);

                // Company
                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', 'PT. MAKERINDO PRIMA SOLUSI');

                // Report Title
                $sheet->mergeCells('A2:D2');
                $sheet->setCellValue('A2', 'DIVISION MASTER REPORT');

                // Date
                $sheet->mergeCells('A3:D3');
                $sheet->setCellValue(
                    'A3',
                    'Generated : ' . now()->format('d F Y H:i')
                );

                // Total
                $sheet->mergeCells('A4:D4');
                $sheet->setCellValue(
                    'A4',
                    'Total Division : ' . $this->divisions->count()
                );

                // Style Company
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'size' => 18,
                        'bold' => true,
                        'color' => ['rgb' => '0D6EFD']
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

                // Style Date
                $sheet->getStyle('A3:A4')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER
                    ]
                ]);

                // Border tabel
                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A5:D{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Freeze header
                $sheet->freezePane('A6');

                // Auto Filter
                $sheet->setAutoFilter("A5:D{$lastRow}");
            }

        ];
    }
}
