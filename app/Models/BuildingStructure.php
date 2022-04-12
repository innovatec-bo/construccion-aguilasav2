<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuildingStructure extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "bui_building_structures";
    protected $primaryKey = "id_bus";

    const CREATED_AT = 'createdon_bus';
    const UPDATED_AT = 'editedon_bus';
}
