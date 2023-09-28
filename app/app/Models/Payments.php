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

    protected $fillable = ['uuid', 'company_id', 'payment_id', 'payer_id', 'total_amount', 'webaook'];
}
