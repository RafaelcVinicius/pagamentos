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

    public function payments(){
        return $this->hasMany(Payments::class, 'company_id', 'id');
    }

    public function paymentsIntention(){
        return $this->hasMany(PaymentsIntention::class, 'company_id', 'id');
    }

    public function payers(){
        return $this->hasMany(Payers::class, 'company_id', 'id');
    }

    public function mercadoPago(){
        return $this->hasOne(GatewayMercadoPago::class, 'company_id', 'id');
    }
}
