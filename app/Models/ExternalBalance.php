<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ExternalBalance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $fillable = [
        'total_records',
        'total_records_221',
        'total_records_222',
        'total_projects',
        'total_material_types',
        'total_BT',
        'total_MT',
        'total_TR'
    ];

    public function materials()
    {
        return $this->hasMany(ExternalBalanceMaterial::class, 'external_balance_id');
    }

    public static function saveData($data): int
    {
        $tensions = [];
        $externalBalanceMaterials = [];
        $data = $data[1];
        $data = new Collection($data);
        $data->shift();
        foreach ($data as $key => $value) 
        {
            //Looking for tensions
            $projectTension = explode('.',$value[0]);
            $projectTension = end($projectTension);
            if(!isset($tensions[$projectTension]))
            {
                $tensions[$projectTension] = 1;
            }
            else
            {
                $tensions[$projectTension]++;
            }
        }
        
        $totalRecords = $data->count();
        $totalProjects = $data->unique(1)->count();
        $totalMaterials = $data->unique(3)->count();
        $records221And222 = $data->groupBy(8)->map(function ($project) {
            return $project->count();
        });
        $records221 = $records221And222['221'];
        $records222 = $records221And222['222'];

        $externalBalance = [
            'total_records' => $totalRecords,
            'total_records_221' => $records221,
            'total_records_222' => $records222,
            'total_projects' => $totalProjects,
            'total_material_types' => $totalMaterials,
            'total_BT' => $tensions['BT'],
            'total_MT' => $tensions['MT'],
            'total_TR' => $tensions['TR']
        ];

        $externalBalance = ExternalBalance::create($externalBalance);
        $date = date('Y-m-d H:i:s');
        foreach ($data as $value) 
        {
            //Preparing data to save in ExternalBalanceMaterial
            $externalBalanceMaterials[] = [
                'ElementoPEP' => $value[0],
                'Proyecto' => $value[1],
                'Contratista' => $value[2],
                'Material' => $value[3],
                'Texto_breve_de_material' => $value[4],
                'Alm' => $value[5],
                'Cantidad' => $value[6],
                'Lote' => $value[7],
                'CMv' => $value[8],
                'Docmat' => $value[9],
                'Reserva' => $value[10],
                'Textocabdocumento' => $value[11],
                'Referencia' => $value[12],
                'Fecontab' => $value[13],
                'Fechadoc' => $value[14],
                'Registrado' => $value[15],
                'EjMat' => $value[16],
                'Cecoste' => $value[17],
                'Grafo' => $value[18],
                'external_balance_id' => $externalBalance->id,
                'created_at' => $date,
                'updated_at' => $date,
                'created_by' => Auth::user()->id_usr
            ];
        }
        foreach (array_chunk($externalBalanceMaterials,1000) as $chunk) 
        {
            ExternalBalanceMaterial::insert($chunk);
        }
        
        return $externalBalance->id;
    }
}
