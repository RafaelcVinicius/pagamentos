<?php

namespace App\Models;

use Dotenv\Parser\Parser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payers extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'payers';

    protected $fillable = ['uuid', 'first_name', 'last_name', 'email', 'cnpjcpf', 'phone'];

    public function address(){
        return $this->hasOne(PayersAddress::class, 'payer_id', 'id');
    }

    public function mercadoPago(){
        return $this->hasOne(CustomersMercadoPago::class, 'payer_id', 'id');
    }
}
