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

    public function payers(){
        return $this->hasMany(payerss::class, 'company_id', 'id');
    }
}
