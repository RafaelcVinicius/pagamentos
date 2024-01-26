<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentIntentionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "uuid"              => $this->uuid,
            "checkoutUrl"       => config('constants.APP_URL_FRONT') . "/v1?uuid=" . $this->uuid,
            "totalAmount"       => (float)$this->total_amount,
            "status"            => $this->when($this->payment != null && $this->payment?->lastStatus() != null,  $this->payment?->lastStatus()->status, "awaited_payment"),
            "webhook"           => $this->webhook,
            "callbackUrl"       => $this->callback_url,
            "gateway"           => $this->gateway,
            "origin"            => $this->origin,
            "company"           => $this->when($this->company, function () {
                return new CompanyResource($this->company);
            }),
            "payer"             => $this->when($this->payer, function () {
                return new PayerResource($this->payer);
            }),
            "additionalInfo"    => json_decode($this->additional_info),
            "payment"           => $this->when($this->payment, function () {
                return new PaymentResource($this->payment);
            }),
            "dateCreate"        => $this->created_at,
            "dateUpdate"        => $this->updated_at,
        ];
    }
}
