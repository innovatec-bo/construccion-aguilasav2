<?php

namespace App\Models;

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
}
