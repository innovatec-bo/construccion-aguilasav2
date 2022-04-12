<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefaultStructureMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "bui_default_structure_materials";
    protected $primaryKey = "id_dms";

    const CREATED_AT = 'createdon_dms';
    const UPDATED_AT = 'editedon_dms';

    public function structure()
    {
        return $this->belongsTo(BuildingStructure::class, 'structure_id_dsm');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id_dsm');
    }
}
