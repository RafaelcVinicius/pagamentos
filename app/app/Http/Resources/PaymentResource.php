<?php

namespace App\Http\Resources;

use App\Models\PaymentFeeDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "uuid"                  => $this->uuid,
            'transectionAmount'     => $this->transection_amount,
            'origemAmount'          => $this->origem_amount,
            'gateway'               => new GatewayResource($this->gateway),
            'payer'                 => new PayerResource($this->payer),
            'feeDetails'            => $this->when($this->paymentFeeDelails, new PaymentFeeDelailsCollection($this->paymentFeeDelails)),
            'delailCards'           => $this->when($this->paymentDelailCards, new PaymentDelailCardsCollection($this->paymentDelailCards)),
            'delailPix'             => $this->when($this->paymentDelailPix, new PaymentDelailPixResource($this->paymentDelailPix)),
            'webHook'               => $this->webhook,
        ];
    }
}
