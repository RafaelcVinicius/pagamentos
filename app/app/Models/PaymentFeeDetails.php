<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentFeeDetails extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'payment_fee_details';

    protected $fillable = ['payment_id', 'type', 'original_amount', 'refunded_amount'];
}
