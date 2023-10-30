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
        $projectArrayCodes = array_unique(array_column($data->toArray(),1));
        $allowedProjects = Project::where('deleted_pro','!=', 1)->where('entry_date_pro',">=",'2021-09-01')->whereIn('code_pro',$projectArrayCodes)->pluck('code_pro')->toArray();
        foreach ($data as $value) 
        {
            if(!in_array($value[1],$allowedProjects))
            {
                continue;
            }
            $elementoPEP = $value[0];
            $proyecto = $value[1];
            $material = $value[3];
            $Alm = $value[5];
            $cantidad = $value[6];
            $lote = $value[7];
            $CMv = $value[8];
            $Docmat = $value[9];
            $reserva = $value[10];
            $Fecontab = $value[13];
            $Fechadoc = $value[14];
            $registrado = $value[15];
            $EjMat = $value[16];
            $Cecoste = $value[17];
            //Preparing data to save in ExternalBalanceMaterial
            $keyList = [$elementoPEP, $proyecto, $material, $Alm, $cantidad, $lote, $CMv, $Docmat, $reserva, $Fecontab, $Fechadoc, $registrado, $EjMat, $Cecoste];
            $key = implode('-',$keyList);

            $externalBalanceMaterials[$key] = [
                'ElementoPEP' => $elementoPEP,
                'Proyecto' => $proyecto,
                'Contratista' => $value[2],
                'Material' => $material,
                'Texto_breve_de_material' => $value[4],
                'Alm' => $Alm,
                'Cantidad' => $cantidad,
                'Lote' => $lote,
                'CMv' => $CMv,
                'Docmat' => $Docmat,
                'Reserva' => $reserva,
                'Textocabdocumento' => $value[11],
                'Referencia' => $value[12],
                'Fecontab' => $Fecontab,
                'Fechadoc' => $Fechadoc,
                'Registrado' => $registrado,
                'EjMat' => $EjMat,
                'Cecoste' => $Cecoste,
                'Grafo' => $value[18],
                'external_balance_id' => $externalBalance->id,
                'created_at' => $date,
                'updated_at' => $date,
                'created_by' => Auth::user()->id_usr
            ];
        }
        // dd(count($externalBalanceMaterials));
        foreach (array_chunk($externalBalanceMaterials,1000) as $chunk) 
        {
            ExternalBalanceMaterial::insert($chunk);
        }
        
        return $externalBalance->id;
    }
}
