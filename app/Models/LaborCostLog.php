<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaborCostLog extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;

    protected $table = "bui_labor_cost_log";
    protected $primaryKey = "id_lal";
    protected $casts = [
        'manual_entry_date_lal'=> 'datetime'
    ];
    const CREATED_AT = 'createdon_lal';
    const UPDATED_AT = 'editedon_lal';
    const UPDATED_BY = 'editedby_lal';

    public function workedUpStructures()
    {
        return $this->hasMany(WorkedUpStructure::class, 'labor_cost_log_id_wus');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_lal');
    }
}
