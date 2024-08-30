<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuilderInManpower extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;

    protected $table = "bui_builders_in_manpower";
    protected $primaryKey = "id_bim";

    const CREATED_AT = 'createdon_bim';
    const UPDATED_AT = 'editedon_bim';
    const UPDATED_BY = 'editedby_bim';
}
