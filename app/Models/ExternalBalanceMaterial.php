<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalBalanceMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'ElementoPEP',
        'Proyecto',
        'Contratista',
        'Material',
        'Texto_breve_de_material',
        'Alm',
        'Cantidad',
        'Lote',
        'CMv',
        'Docmat',
        'Reserva',
        'Textocabdocumento',
        'Referencia',
        'Fecontab',
        'Fechadoc',
        'Registrado',
        'EjMat',
        'Cecoste',
        'Grafo'
    ];

    public static function parseData(array $data): void
    {
        $dataToSave = [];
        array_shift($data);
        foreach ($data as &$value) 
        {
            if ($value[13] != '') 
            {
                $value[13] = Carbon::createFromFormat('d.m.Y',$value[13])->format('Y-m-d');
            }
            if ($value[14] != '') 
            {
                $value[14] = Carbon::createFromFormat('d.m.Y',$value[14])->format('Y-m-d');
            }
            if ($value[15] != '') 
            {
                $value[15] = Carbon::createFromFormat('d.m.Y',$value[15])->format('Y-m-d');
            }
            
        }
        ExternalBalanceMaterial::insert($data);
    }
}
