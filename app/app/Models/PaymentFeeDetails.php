<?php

namespace App\Models;

use App\Traits\HasDecimalFields;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PaymentFeeDetails extends Model
{
    use HasFactory;
    use HasDecimalFields;

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'payment_fee_details';

    protected $fillable = ['payment_id', 'type', 'original_amount', 'refunded_amount'];

    public function originalAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getDecimal($value),
            set: fn ($value) => $this->setDecimal($value)
        );
    }

    public function refundedAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getDecimal($value),
            set: fn ($value) => $this->setDecimal($value)
        );
    }
}
