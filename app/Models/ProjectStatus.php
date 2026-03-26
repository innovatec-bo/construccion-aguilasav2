<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectStatus extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;
    
    protected $table = "wfl_project_status";
    protected $primaryKey = "id_pst";

    const CREATED_AT = 'createdon_pst';
    const UPDATED_AT = 'editedon_pst';

    public function responsibles()
    {
        return $this->belongsToMany(User::class, 'wfl_status_responsibles', 'status_id_sre', 'user_id_sre')->withPivot('active_sre','id_sre');
    }
}
