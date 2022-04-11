<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialTension extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "mat_material_tensions";
    protected $primaryKey = "id_mte";

    const CREATED_AT = 'createdon_mte';
    const UPDATED_AT = 'editedon_mte';
}
