<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentsIntention extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'payments_intention';

    protected $fillable = ['uuid', 'company_id', 'payer_id', 'gateway', 'total_amount', 'webhook', 'callback_url', 'additional_info' ];

    public function company(){
        return $this->hasOne(Companies::class, 'id', 'company_id');
    }

    public function payer(){
        return $this->hasOne(Payers::class, 'id', 'payer_id');
    }

    public function payment(){
        return $this->hasOne(Payments::class, 'id', 'payment_id');
    }
}
