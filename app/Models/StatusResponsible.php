<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusResponsible extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;
    
    protected $table = "wfl_status_responsibles";
    protected $primaryKey = "id_sre";
    protected $casts = [
        'active_sre' => 'boolean'
    ];
    const CREATED_AT = 'createdon_sre';
    const UPDATED_AT = 'editedon_sre';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id_sre');
    }

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id_sre');
    }

    public function statusLogResponsible()
    {
        return $this->hasMany(StatusLogResponsible::class, 'responsible_id_slr');
    }
}
