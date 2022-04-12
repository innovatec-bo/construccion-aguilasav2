<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStatusLog extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "wfl_project_status_log";
    protected $primaryKey = "id_psl";

    protected $casts = [
        'manual_entry_date_psl' => 'datetime'
    ];

    const CREATED_AT = 'createdon_psl';
    const UPDATED_AT = 'editedon_psl';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id_psl');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id_psl');
    }
}
