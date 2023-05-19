<?php

namespace App\Imports;

use App\Models\ExternalBalanceMaterial;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ExternalBalanceMaterialDataImport implements ToModel, WithBatchInserts, WithChunkReading, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // foreach ($rows as $row) 
        // {
            if(strtolower($row[2]) == 'serebo')
            {
                return new ExternalBalanceMaterial([
                    'ElementoPEP' => $row[0],
                    'Proyecto' => $row[1],
                    'Contratista' => $row[2],
                    'Material' => $row[3],
                    'Texto_breve_de_material' => $row[4],
                    'Alm' => $row[5],
                    'Cantidad' => $row[6],
                    'Lote' => $row[7],
                    'CMv' => $row[8],
                    'Docmat' => $row[9],
                    'Reserva' => $row[10],
                    'Textocabdocumento' => $row[11],
                    'Referencia' => $row[12],
                    'Fecontab' => $row[13],
                    'Fechadoc' => $row[14],
                    'Registrado' => $row[15],
                    'EjMat' => $row[16],
                    'Cecoste' => $row[17],
                    'Grafo' => $row[18]
                    // 'CMv' => '',
                    // 'Docmat' => '',
                    // 'Reserva' => '',
                    // 'Textocabdocumento' => '',
                    // 'Referencia' => '',
                    // 'Fecontab' => '',
                    // 'Fechadoc' => '',
                    // 'Registrado' => '',
                    // 'EjMat' => '',
                    // 'Cecoste' => '',
                    // 'Grafo' => ''
                ]);
            }
        // }
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
