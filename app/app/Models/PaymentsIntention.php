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

    public function company(){
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function paymer(){
        return $this->hasOne(Paymer::class, 'id', 'paymer_id');
    }

    public function payment(){
        return $this->hasOne(Payments::class, 'id', 'payment_id');
    }
}
