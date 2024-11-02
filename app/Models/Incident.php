<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;

    protected $table = "wfl_incidents";
    protected $primaryKey = "id_inc";
    protected $casts = [
        'manual_entry_date_inc' => 'datetime',
        'paused_inc' => 'boolean',
        'created_at' => 'datetime',
        'createdon_inc' => 'datetime'
    ];

    protected $fillable = [
        'project_id_inc',
        'status_id_inc',
        'percentage_inc',
        'detail_inc',
        'manual_entry_date_inc',
        'paused_inc',
        'stopped_inc',
        'incident_type_inc',
        'need_to_be_solved_inc',
        'solved_by_inc',
        'created_by',
        'created_at',
        'createdby_inc',
        'createdon_inc'
    ];

    const CREATED_AT = 'createdon_inc';
    const UPDATED_AT = 'editedon_inc';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id_inc');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id_inc');
    }
}
