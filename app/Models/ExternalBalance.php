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

    public function materials()
    {
        return $this->hasMany(ExternalBalanceMaterial::class, 'external_balance_id');
    }

    public static function saveData($data): void
    {
        $dataToSave = [];
        $data = $data[1];
        // $data->shift();
        // $data = $data->slice(0,30);
        foreach ($data as $key => &$value) 
        {
            // if ($key > 0) 
            // {
                // if ($value[13] != '') 
                // {
                //     $value[13] = Carbon::createFromFormat('d.m.Y',$value[13])->format('Y-m-d');
                // }
                // if ($value[14] != '') 
                // {
                //     $value[14] = Carbon::createFromFormat('d.m.Y',$value[14])->format('Y-m-d');
                // }
                // if ($value[15] != '') 
                // {
                //     $value[15] = Carbon::createFromFormat('d.m.Y',$value[15])->format('Y-m-d');
                // }
            // }   
        }
        $data = new Collection($data);
        $totalRecords = $data->count();
        $totalProjects = $data->unique(1)->count();
        $totalMaterials = $data->unique(3)->count();
        dd('toc toc',$totalRecords, $totalProjects);
        ExternalBalanceMaterial::insert($data);
    }
}
