<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStatus extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "wfl_project_status";
    protected $primaryKey = "id_pst";

    const CREATED_AT = 'createdon_pst';
    const UPDATED_AT = 'editedon_pst';
}
