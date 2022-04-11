<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "mat_materials";
    protected $primaryKey = "id_mat";

    const CREATED_AT = 'createdon_mat';
    const UPDATED_AT = 'editedon_mat';
}
