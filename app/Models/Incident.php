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
        'created_at' => 'datetime',
        'createdon_inc' => 'datetime'
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
