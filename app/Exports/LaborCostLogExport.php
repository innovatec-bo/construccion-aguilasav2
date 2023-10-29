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
use Maatwebsite\Excel\Events\AfterSheet;
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
    protected $_laborCosts;

    public function __construct(Project $project)
    {
        $this->_project = $project;
        $this->_laborCosts = $this->_project->laborDetailDesign->laborCosts;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        return $this->_laborCosts;
    }

    public function map($row) : array
    {
        $logString = "";
        foreach ($row->changeLog as $key => $log) 
        {
            $logString .= "(De ".$log->quantity_from." a ".$log->quantity_to." en fecha ".$log->created_at->format('d-m-Y H:i:s').")";
        }
        $logString .=" ";
        return [
            $row->buildingStructure->structure_code_bus,
            $row->buildingStructure->description_bus,
            $row->activity_lac,
            $row->execution_lac,
            $row->quantity_lac,
            $row->unit_price_lac,
            $row->is_additional_lac == 1?'Si':'No',
            $logString
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
        $laborCosts = $this->_laborCosts;
        return [
            // Array callable, refering to a static method.
            AfterSheet::class => function(AfterSheet $event)use($laborCosts){
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(35);
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(30);
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->getStyle('A1:H'.(count($laborCosts) + 2))->applyFromArray([
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
