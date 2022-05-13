<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaborCost extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "bui_labor_cost";
    protected $primaryKey = "id_lac";

    const CREATED_AT = 'createdon_lac';
    const UPDATED_AT = 'editedon_lac';

    public function laborDetail()
    {
        return $this->belongsTo(LaborDetail::class,'labor_detail_id_lac');
    }

    public function buildingStructure()
    {
        return $this->belongsTo(BuildingStructure::class, 'building_structure_id_lac');
    }

    public function customStructureMaterials()
    {
        return $this->hasMany(CustomStructureMaterial::class, 'labor_cost_id');
    }
}
