<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusLogResponsible extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;
    
    protected $table = "wfl_status_log_responsibles";
    protected $primaryKey = "id_slr";

    const CREATED_AT = 'createdon_slr';
    const UPDATED_AT = 'editedon_slr';

    public function projectStatusLog()
    {
        return $this->belongsTo(ProjectStatusLog::class,'status_log_id_slr');
    }

    public function responsible()
    {
        return $this->belongsTo(StatusResponsible::class, 'responsible_id_slr');
    }
}
