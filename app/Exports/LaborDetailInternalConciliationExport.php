<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaborDetailInternalConciliationExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $_data;

    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->_data;
    }

    public function map($row) : array
    {
        return [
            $row->buildingStructure->structure_code_bus,
            $row->buildingStructure->description_bus,
            $row->activity_lac,
            $row->execution_lac,
            $row->quantity_lac,
        ];
    }

    public function headings(): array
    {
        return [
            'Codigo',
            'Descripcion',
            "Cantidad a\nretirar",
            "Cantidad devuelta\na almacen",
            'Diferencia'
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
                $event->sheet->getStyle('A1:H'.(count($data) + 1))->applyFromArray([
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
}
