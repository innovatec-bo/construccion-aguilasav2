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

class LaborDetailExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
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
            $row->unit_price_lac,
            $row->is_additional_lac == 1?"Si":"No",
            $row->customStructureMaterials->count()
        ];
    }

    public function headings(): array
    {
        return [
            'Codigo',
            'Detalle',
            'Actividad',
            'Ejecucion',
            'Cantidad',
            "Precio\nUnitario",
            "Es\nadicional?",
            "Nro.\nMateriales",
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
