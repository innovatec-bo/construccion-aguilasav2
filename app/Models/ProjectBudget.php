<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectBudget extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;

    protected $table = "wfl_project_budgets";
    protected $primaryKey = "id_prb";

    const CREATED_AT = 'createdon_prb';
    const UPDATED_AT = 'editedon_prb';
    const UPDATED_BY = 'editedby_prb';

    protected $guarded = [
        'createdon_prb',
        'editedon_prb',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function project()
    {
        return $this->hasOneThrough(
            Project::class,
            ProjectStatusLog::class,
            'id_psl',              // Foreign key en ProjectStatusLog
            'id_pro',              // Foreign key en Project
            'status_log_id_prb',   // Foreign key local en ProjectBudget
            'project_id_psl'       // Foreign key en ProjectStatusLog
        );
    }

    public function projectStatusLog()
    {
        return $this->belongsTo(ProjectStatusLog::class, 'status_log_id_prb');
    }

    public function treePruning()
    {
        return $this->hasMany(TreePruning::class, 'budget_id');
    }
}
