<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectRealBudget extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;

    protected $table = "wfl_project_real_budgets";
    protected $primaryKey = "id_reb";

    const CREATED_AT = 'createdon_reb';
    const UPDATED_AT = 'editedon_reb';
    const UPDATED_BY = 'editedby_reb';

    protected $guarded = [
        'createdon_reb',
        'editedon_reb',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function projectStatusLog()
    {
        return $this->belongsTo(ProjectStatusLog::class, 'status_log_id_reb');
    }
}
