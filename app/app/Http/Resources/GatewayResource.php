<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GatewayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "mercadoPago" => $this->when($this->mercadopago, [
                // "accessToken" => $this->mercadopago?->access_token,
                "publicKey" => $this->mercadopago?->public_key,
            ]),
        ];
    }
}
