<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkedUpStructure extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;

    protected $table = "bui_worked_up_structures";
    protected $primaryKey = "id_wus";

    const CREATED_AT = 'createdon_wus';
    const UPDATED_AT = 'editedon_wus';
    const UPDATED_BY = 'editedby_wus';

    public function laborCost()
    {
        return $this->belongsTo(LaborCost::class, 'labor_cost_id_wus');
    }

    public function log()
    {
        return $this->belongsTo(LaborCostLog::class,'labor_cost_log_id_wus');
    }

    public static function updatePrices(Project $project, array $data)
    {
        
    }
}
