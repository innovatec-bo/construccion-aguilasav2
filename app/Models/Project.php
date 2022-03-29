<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "wfl_projects";
    protected $primaryKey = "id_pro";

    const CREATED_AT = 'createdon_pro';
    // const UPDATED_AT = 'editedon_pro';

    // protected $casts = [
    //     'createdon_pro' => 'datetime'
    // ];
}
