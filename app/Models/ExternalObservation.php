<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalObservation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = "wfl_external_fiscal_observations";
    protected $primaryKey = "id_efo";

    protected $casts = [
        'entry_date_efo' => 'datetime',
        'fixed_date_efo' => 'datetime'
    ];

    const CREATED_AT = 'createdon_efo';
    const UPDATED_AT = 'editedon_efo';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id_efo');
    }

    public function fiscal()
    {
        return $this->belongsTo(User::class, 'fiscal_id_efo');
    }

    public function fixedBy()
    {
        return $this->belongsTo(User::class, 'fixed_by_efo');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id_efo');
    }
}
