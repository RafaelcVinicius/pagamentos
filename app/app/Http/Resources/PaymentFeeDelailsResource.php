<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentFeeDelailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "type"                  => $this->type,
            'originalAmount'       => $this->original_amount,
            'refundedAmount'       => $this->refunded_amount,
        ];
    }
}
