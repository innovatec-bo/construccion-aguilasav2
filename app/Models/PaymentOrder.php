<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOrder extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "wfl_payment_orders";
    protected $primaryKey = "id_pao";

    const CREATED_AT = 'createdon_pao';
    const UPDATED_AT = 'editedon_pao';

    public function paymentOrderProyects()
    {
        return $this->hasMany(PaymentOrderProyect::class, 'order_id_pop')->where('deleted_pop','!=',1);
    }
}
