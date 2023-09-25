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
            "uuid" => $this->uuid,
            "total_amount"      => $this->total_amount,
            "webhook"           => $this->webhook,
            "company"           => $this->whenLoaded('company', function() {
                return new CompanyResource($this->company);
            }),
            "paymer"            => $this->whenLoaded('paymer', function() {
                return new CompanyResource($this->company);
            }),
            "dateCreate"        => $this->date_create,
            "dateUpdate"        => $this->date_update,
        ];
    }
}
