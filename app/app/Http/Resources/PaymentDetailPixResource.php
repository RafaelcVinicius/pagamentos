<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetailPixResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'e2eId'             => $this->e2e_id,
            'qrCode'            => $this->qr_code,
            'expiresOn'         => $this->expires_on,
        ];
    }
}
