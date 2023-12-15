<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'payments';

    protected $fillable = [
        'uuid', 'email', 'gateway_payment_id', 'payment_type', 'payment_intention_id', 'transection_amount'
    ];

    public function payer(){
        return $this->hasOne(Payers::class, 'id', 'payers_id');
    }

    public function status(){
        return $this->hasOne(PaymentsStatus::class, 'payment_id', 'id');
    }

    public function paymentIntention(){
        return $this->hasOne(PaymentsIntention::class, 'id', 'payment_intention_id');
    }
}
