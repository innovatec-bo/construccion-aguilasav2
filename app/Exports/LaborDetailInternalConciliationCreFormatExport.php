<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LaborDetailInternalConciliationCreFormatExport implements FromArray , WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithEvents, WithColumnFormatting
{
    protected $_data;

    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->_data;
    }

    public function map($row) : array
    {
        return [
            $row['material_code'],
            $row['material_description'],
            $row['materials_picked_up_from_cre'],
            $row['total_used'],
            $row['return_to_serebo'],
            $row['return_to_cre'],
            $row['builder_returns_materials_meo']
        ];
    }

    public function headings(): array
    {
        return [
            "Codigo",
            "Descripcion",
            "Retirado\nde CRE",
            "Entregado menos\ndevuelto (NVO)",
            "Devuelve\nCRE(NVO)",
            "Devuelve\nSEREBO(NVO)",
            "Devuelve\nSEREBO(MEO)"
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        $data = $this->_data;
        return [
            // Array callable, refering to a static method.
            AfterSheet::class => function(AfterSheet $event)use($data){
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(35);
                $event->sheet->getStyle('A1:G'.(count($data) + 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },     
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
