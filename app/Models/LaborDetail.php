<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaborDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "bui_labor_details";
    protected $primaryKey = "id_lad";

    const CREATED_AT = 'createdon_lad';
    const UPDATED_AT = 'editedon_lad';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id_lad');
    }

    public function laborCosts()
    {
        return $this->hasMany(LaborCost::class, 'labor_detail_id_lac');
    }
}
