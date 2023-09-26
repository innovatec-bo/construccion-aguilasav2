<?php

namespace App\Imports;

use App\Models\ExternalBalanceMaterial;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExternalBalanceMaterialDataImport implements ToCollection, WithBatchInserts, WithChunkReading, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        //$rows->shift();//Removed first row
        foreach ($rows as $key => $row) 
        {
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
                    'Fecontab' => $row[13] !=''?Carbon::createFromFormat('d.m.Y', $row[13])->format('Y-m-d'):$row[13],
                    'Fechadoc' => $row[14] !=''?Carbon::createFromFormat('d.m.Y', $row[14])->format('Y-m-d'):$row[14],
                    'Registrado' => $row[15] !=''?Carbon::createFromFormat('d.m.Y', $row[15])->format('Y-m-d'):$row[15],
                    'EjMat' => $row[16],
                    'Cecoste' => $row[17],
                    'Grafo' => $row[18]
                ]);
            }
        }
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
