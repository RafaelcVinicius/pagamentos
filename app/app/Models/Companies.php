<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'companies';

    protected $fillable = ['uuid', 'email', 'cnpjcpf', 'business_name'];

    public function payments()
    {
        // return $this->hasManyThrough(
        //     Payments::class,
        //     PaymentsIntention::class,
        //     'company_id',
        //     'payment_intention_id',
        // );

        return $this->throughPaymentsIntention()->hasPayment();
    }

    public function paymentsIntention()
    {
        return $this->hasMany(PaymentsIntention::class, 'company_id', 'id');
    }

    public function payers()
    {
        return $this->hasMany(Payers::class, 'company_id', 'id');
    }

    public function mercadoPago()
    {
        return $this->hasOne(GatewayMercadoPago::class, 'company_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
