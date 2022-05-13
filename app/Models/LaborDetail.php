<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LaborDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "bui_labor_details";
    protected $primaryKey = "id_lad";

    const CREATED_AT = 'createdon_lad';
    const UPDATED_AT = 'editedon_lad';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id_lad');
    }

    public function laborCosts()
    {
        return $this->hasMany(LaborCost::class, 'labor_detail_id_lac');
    }

    public function defaultStructureMaterials()
    {
        $defaultMaterials = DefaultStructureMaterial::whereHas('structure', function(Builder $query){
            $query->whereHas('laborCosts', function(Builder $query){
                $query->whereHas('laborDetail', function(Builder $query){
                   $query->where('project_id_lad', $this->attributes['project_id_lad']); 
                });
            });
        })->get();
        return $defaultMaterials;
    }

    public function customStructureMaterials()
    {
        $customMaterials = CustomStructureMaterial::whereHas('laborCost', function(Builder $query){
            $query->whereHas('laborDetail', function(Builder $query){
                $query->where('project_id_lad', $this->attributes['project_id_lad']); 
            });
        })->get();
        return $customMaterials;
    }

    public function getHasCustomMaterialsAttribute()
    {
        $defaultMaterials = $this->defaultStructureMaterials();
        $customMaterials = $this->customStructureMaterials();

        $response = true;
        if($defaultMaterials->count() > 0 && $customMaterials->count() == 0)
            $response = false;

        return $response;
    }

    public function applyCustomMaterials()
    {
        if(!$this->hasCustomMaterials)
        {
            $saveAsCustom = [];
            foreach ($this->laborCosts as $laborCost) 
            {
                foreach ($laborCost->buildingStructure->defaultStructureMaterials as $default) 
                {
                    // $newCustom = new CustomStructureMaterial;
                    // $newCustom->labor_cost_id = $laborCost->id_lac;
                    // $newCustom->material_id_csm = $default->material_id_dsm;
                    // $newCustom->quantity_csm = $default->quantity_dsm;
                    // dd($newCustom->created_at);
                    // $saveAsCustom[] = $newCustom;
                    $saveAsCustom[] = [
                        'labor_cost_id' => $laborCost->id_lac,
                        'material_id_csm' => $default->material_id_dsm,
                        'quantity_csm' => $default->quantity_dsm
                    ];
                    $object = new CustomStructureMaterial();
                    $saveAsCustom = array_map(function ($data) use ($object) {
                        $timestamp = $object->freshTimestampString();
                        $data['created_at'] = $timestamp;
                        $data['created_by'] = Auth::user()->id_usr;
                        return $data;
                    }, $saveAsCustom);
                }
            }
            if(count($saveAsCustom) > 0)
            {
                CustomStructureMaterial::insert($saveAsCustom);
            }
        }
    }
}
