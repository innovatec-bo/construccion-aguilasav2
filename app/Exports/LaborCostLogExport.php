<?php

namespace App\Exports;

use App\Models\LaborDetail;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaborCostLogExport implements 
    FromCollection, 
    WithMapping,
    WithHeadings,
    ShouldAutoSize,
    WithStyles, 
    WithEvents
{
    protected $_project;
    protected $_laborCost;

    public function __construct(Project $project)
    {
        $this->_project = $project;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $this->_laborCost = $this->_project->laborDetailDesign->laborCosts;

        return $this->_laborCost;
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
            $row->is_additional_lac == 1?'Si':'No',
            ''
        ];
    }

    public function headings(): array
    {
        $mainHeading = [
            'Reporte de modificacion de cantidades'
        ];
        $columnHeadings = [
            'Estructura',
            'Descripcion',
            'Actividad',
            'Ejecucion',
            'Cantidad',
            'Prec. Unit.',
            'Es adicional',
            'Modificaciones'
        ];
        return [$mainHeading, $columnHeadings];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            2    => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        $payments = $this->_payments;
        return [
            // Array callable, refering to a static method.
            AfterSheet::class => function(AfterSheet $event)use($payments){
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(35);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(30);
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->getStyle('A1:H'.(count($payments) + 2))->applyFromArray([
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
