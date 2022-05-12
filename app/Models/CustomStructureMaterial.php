<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomStructureMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "bui_custom_structure_materials";
    protected $primaryKey = "id_csm";

    const CREATED_AT = 'createdon_csm';
    const UPDATED_AT = 'editedon_csm';
}
