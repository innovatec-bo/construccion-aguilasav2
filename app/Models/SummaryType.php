<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SummaryType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;

    protected $table = "mat_materials_summary_types";
    protected $primaryKey = "id_mqt";

    const CREATED_AT = 'createdon_mqt';
    const UPDATED_AT = 'editedon_mqt';
}
