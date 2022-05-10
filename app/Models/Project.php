<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "wfl_projects";
    protected $primaryKey = "id_pro";

    const CREATED_AT = 'createdon_pro';
    const UPDATED_AT = 'editedon_pro';

    // protected $casts = [
    //     'createdon_pro' => 'datetime'
    // ];

    public function materialSummaries()
    {
        return $this->hasMany(MaterialSummary::class, 'project_id_msu');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_pro');
    }

    public function statusLog()
    {
        return $this->hasMany(ProjectStatusLog::class, 'project_id_psl');
    }

    public function statusLogResponsibles()
    {
        return $this->hasManyThrough(StatusLogResponsible::class, ProjectStatusLog::class,'project_id_psl', 'status_log_id_slr')
        // ->whereHas('responsible', function(Builder $query){
            // $query->whereHas('user', function(Builder $query){
                // $query->with('roles')->whereHas('roles',function(Builder $query){
                    // $query->whereIn('name',['Builder']);
                // });
            // });
        // })
        ->where('status_id_psl',29)
        ->limit(2)
        ->orderBy('manual_entry_date_psl','desc');
    }

    public function builderResponsible__()
    {
        return $this->hasOne(ProjectStatusLog::class, 'project_id_psl')->ofMany([
            'manual_entry_date_psl' => 'max'
        ], function($query){
            $query->where('status_id_psl', 29);
        });
    }

    // public function getBuilderResponsibleAttribute()
    // {
    //     return User::role('builder')
    //     ->whereHas('statusResponsible', function(Builder $query){
    //         $query->whereHas('statusLogResponsible', function(Builder $query){
    //             $query->whereHas('projectStatusLog', function(Builder $query){
    //                 $query->where('status_id_psl', 29);
    //             });
    //         });
    //     })->get();
    // }

    public function laborDetail()
    {
        return $this->hasOne(LaborDetail::class, 'project_id_lad');
    }
}
