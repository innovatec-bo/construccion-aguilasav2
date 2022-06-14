<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $_users;

    public function __construct($users)
    {
        $this->_users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->_users;
    }

    public function map($row) : array
    {
        return [
            $row->id_usr,
            $row->firstname_usr,
            $row->email_usr,
            $row->getRoleNames()->implode(',')
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Completo',
            'Correo',
            'Rol'
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
        $users = $this->_users;
        return [
            // Array callable, refering to a static method.
            AfterSheet::class => function(AfterSheet $event)use($users){
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(35);
                $event->sheet->getStyle('A1:D'.(count($users) + 1))->applyFromArray([
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
