<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

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
        $data = $data[1];
        $data = new Collection($data);
        $data->shift();
        foreach ($data as $key => $value) 
        {
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
        $externalBalance->materials()->save($data);
        return $externalBalance->id;
    }
}
