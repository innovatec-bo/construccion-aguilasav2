<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "wfl_contracts";
    protected $primaryKey = "id_con";

    const CREATED_AT = 'createdon_con';
    const UPDATED_AT = 'editedon_con';

    protected $casts = [
        'start_date_con' => 'datetime',
        'expiration_date_con' => 'datetime',
        'active' => 'boolean'
    ];
}
