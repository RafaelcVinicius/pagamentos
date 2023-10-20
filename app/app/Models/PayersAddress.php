<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayersAddress extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'payers_address';

    protected $fillable = ['payer_id', 'zip_code', 'street_name', 'street_number', 'city'];
}
