<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "mat_material_status";
    protected $primaryKey = "id_mst";

    const CREATED_AT = 'createdon_mst';
    const UPDATED_AT = 'editedon_mst';
}
