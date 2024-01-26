<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetailCards extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'payment_detail_cards';

    protected $fillable = ['payment_id', 'payment_method', 'first_digits', 'last_digits'];
}
