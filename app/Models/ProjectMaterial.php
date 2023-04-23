<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "mat_projects_materials";
    protected $primaryKey = "id_prm";
    protected $fillable = [
        'material_id_prm',
        'quantity_prm',
        'status_id_prm',
        'tension_id_prm'
    ];

    const CREATED_AT = 'createdon_prm';
    const UPDATED_AT = 'editedon_prm';

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id_prm');
    }

    public function status()
    {
        return $this->belongsTo(MaterialStatus::class, 'status_id_prm');
    }

    public function tension()
    {
        return $this->belongsTo(MaterialTension::class, 'tension_id_prm');
    }

    public function delete()
    {
        $this->deleted_prm = 1;
        parent::delete();
    }
}
