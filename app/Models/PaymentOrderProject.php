<?php

namespace App\Models;

use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOrderProject extends Model
{
    
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;
    
    protected $table = "wfl_payment_orders_projects";
    protected $primaryKey = "id_pop";

    const CREATED_AT = 'createdon_pop';
    const UPDATED_AT = 'editedon_pop';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id_pop');
    }
}
