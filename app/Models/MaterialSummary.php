<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialSummary extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    use \Bkwld\Cloner\Cloneable;

    protected $table = "mat_materials_summary";
    protected $primaryKey = "id_msu";

    const CREATED_AT = 'createdon_msu';
    const UPDATED_AT = 'editedon_msu';

    protected $casts = [
        'entry_date_msu' => 'datetime'
    ];

    protected $guarded = [
        'createdon_msu',
        'editedon_msu'
    ];

    public function fiscal()
    {
        return $this->belongsTo(User::class, 'fiscal_responsible_msu');
    }

    public function builder()
    {
        return $this->belongsTo(User::class, 'builder_responsible_msu');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id_msu');
    }

    public function summaryType()
    {
        return $this->belongsTo(SummaryType::class, 'summary_type_id_msu');
    }

    public function projectMaterials()
    {
        return $this->hasMany(ProjectMaterial::class, 'materials_summary_id_prm');
    }

    public function delete()
    {
        foreach ($this->projectMaterials as $row) 
        {
            $row->delete();
        }
        $this->deleted_msu = 1;
        parent::delete();
    }
}
