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
        'uuid', 'gateway_payment_id', 'company_id', 'payer_id', 'payment_id', 'payment_type', 'gateway',
        'gateway_id', 'origem_amount', 'transection_amount', 'webaook'
    ];

    public function company(){
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function payer(){
        return $this->hasOne(Payers::class, 'id', 'payers_id');
    }

    public function paymentIntention(){
        return $this->hasOne(PaymentsIntention::class, 'payment_id', 'id');
    }
}
